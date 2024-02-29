const { readFileSync } = require("fs");
const { createServer } = require("https");
const { Server } = require("socket.io");

const httpServer = createServer({
  key: readFileSync("/home5/urlpyrtf/ssl/keys/ccc28_c0e85_ed9eb2bd7fa9f3359af9f0e73be2db01.key"),
  cert: readFileSync("/home5/urlpyrtf/ssl/certs/findsol_it_ccc28_c0e85_1713732854_2ee449862927312874cc97263b9c6ff3.crt")
});

const io = new Server(httpServer, {
    cors: {
        origin: "https://findsol.it",
        methods: ["GET", "POST"]
    }
});

var helper = require('./utils/helper');

var users_login_list = {};
var user_ids = [];

io.on('connection', function(socket) {
    /*---------------LOGIN USER, ADD BTNONLINE, DISCONNECT USER, DELETE BTNONLINE-----------*/
    socket.on('login', function(id_user_login) { //принимаем id пользователя который должен аторизоваться
        helper.loginUser({socketId: socket.id, id: id_user_login}).then((result) => {
            user_ids.push(id_user_login);
            socket.user_id = id_user_login;
            users_login_list[id_user_login] = socket.id;
            ifUserOnline(socket.user_id);
            
            getUserslist({show_status: 'All'});
        });
    });

    socket.on('ifAuthorOnline', function(id_author) {
        ifUserOnline(id_author);
    });

    socket.on('disconnect', function () {
        helper.logOutUser({id: socket.user_id, s_id: socket.id}).then((result) => {
            user_ids.splice( user_ids.indexOf(socket.user_id), 1 );
            delete users_login_list[socket.user_id];
        });
        
        setTimeout(function () {
            ifUserOnline(socket.user_id);
        }, 2000);
    });
    /*---------------/LOGIN USER, ADD BTNONLINE, DISCONNECT USER, DELETE BTNONLINE-----------*/
    
    
    
    
    
    
    /*-----START CHAT-----*/
    socket.on('startchat', function  (id_author) {
        addUserInChatList({id_user: socket.user_id, id_for: id_author});
    });
    
    socket.on('getUsersList', function (data) {
        getUserslist(data);
    });
    
    socket.on('getHistoryDialog', function(data) { //получаем историю сообщений
    	getHistoryDialog(data);
        updateReadStatus(data);
    });
    
    /*socket.on('deletemsg', function(data) {
        
        getHistoryDialog(data);
    });*/
    
    socket.on('updateReadStatus', function(data){
        updateReadStatus(data);
    });
    
    socket.on('send', function  (data) {//принимаем сообщение от клиента чтоб записать его в базу и вывести получателю
        helper.insertMessages({usr_from: socket.user_id, usr_to: data.usr, msg: data.msg}).then((result) => {
            //if(result !== null) {
            addUserInChatList({id_user: data.usr, id_for: socket.user_id});
            //console.log(users_login_list);
            io.to(users_login_list[data.usr]).emit('sendmsg', {msg:data.msg, usr:socket.user_id});
            //}
        });
    });
    
    socket.on('getNewMsgs', function(data) {
        helper.getNewMsgs({usr_from: socket.user_id, usr_to: data.usr_to}).then((result) => {
            socket.emit('setNewMsgs', {num: result[0].num, usr: data.usr_to});
        });
    });
    
    socket.on('hideUserFromUserlist', function (data) {
        helper.updateUserShowStatus({usr_to: data.usr_to, usr_from: socket.user_id}).then((result) => {
            if(result !== null) getUserslist({show_status: 1});
        });
    });

    socket.on('dltUserFromUserlist', function (data) {
        helper.dltUserFromUserlist({usr_to: data.usr_to, usr_from: socket.user_id}).then((result) => {
            if(result !== null) getUserslist({show_status: 1});
        });
    });
    /*-----/START CHAT-----*/
    
    
    
    
    
    function addUserInChatList(data) {
        helper.addUserInChatList(data).then((result) => {
            if (result != null) getUserslist({show_status: 1});
        });
    }
    
    function updateReadStatus(data) {//обновление статуса сообщения о прочтении на прочитано (1)
        helper.updateReadStatus({id_user_from: socket.user_id, id_user_to: data.usr_to}).then((result) => {});
    }
    
    //delmsg
    
    function getHistoryDialog(data) {//получаем историю сообщений, последние 25 сообщений
        helper.getHistoryDialog({id_user_from: socket.user_id, id_user_to: data.usr_to}).then((result) => {
            socket.emit('addDialogHistory', {arr:result, usr:data.usr_to});
        });
    }
    
    function getUserslist(data) { //функция для получения списка собеседников
        if (data.show_status === 'All') var show_status = '';
        if (data.show_status == 1) var show_status = ' AND tori_users.onlineSatus = 1';
        if (data.show_status == 0) var show_status = ' AND tori_users.onlineSatus = 0';
        
        helper.getUserslist({id_user: socket.user_id, status: show_status}).then((result) => {
            socket.emit('createUsersList', result);
            //console.log(result);
        });
    }
    
    function ifUserOnline(id_user) { //функция проверки пользователя на присутствие на сайте
        helper.ifUserOnline({id: id_user, socketId: users_login_list[id_user]}).then((result) => {
            if (result.length !== 0) {
                io.emit('createBtnChat', {id: result[0].id, login: result[0].login});
                socket.emit('sendStatusUser', {msg:result[0].login+' is online', usr: result[0].id}); //выводим статус пользователя в окно сообщений
            } else {
                io.emit('deleteBtnChat', id_user);
                socket.emit('sendStatusUser', {msg:'User is offline', usr: id_user}); //выводим статус пользователя в окно сообщений
            }
        });
    }
});


httpServer.listen(3000, function(){
    console.log('listening on *:3000');
});