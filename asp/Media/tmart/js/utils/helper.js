const DB = require('./db');

class Helper {
	
	constructor(app){
		this.db = DB;
        this.db.query('SET NAMES utf8mb4', function(err, res) {
            if(err) console.log(err);
        });
        this.db.query("SET SESSION wait_timeout = 604800");
	}

	async ifUserOnline (par){
        try {
            return await this.db.query(`select id, login from tori_users where onlineSatus = 1 and id = ? and socketid = ?`, [par.id, par.socketId]);
        } catch (error) {
			return error;
		}
	}

	async loginUser(par){
		try {
			return await this.db.query(`update tori_users set onlineSatus = 1, socketid = ? where id = ?`, [par.socketId, par.id]);
		} catch (error) {
			return error;
		}
	}

	async addUserInChatList(par){
		try {
			return await this.db.query(`insert into tori_users_list_for_chat(id_user, id_user_in_list) values(?, ?)`, [par.id_user, par.id_for]);
		} catch (error) {
			return null;
		}
	}

	async getUserslist(par){
		try {
			return await this.db.query(`select tori_users.id, tori_users.onlineSatus, tori_users.login, tori_user_date.name, tori_user_date.lastname, tori_user_date.company_name, tori_user_date.type_person, tori_user_date.company_link, tori_user_date.user_img, (SELECT COUNT(message) from tori_message_in_the_chat WHERE tori_message_in_the_chat.to_user_id = ? AND tori_message_in_the_chat.from_user_id = tori_users_list_for_chat.id_user_in_list AND tori_users_list_for_chat.id_user = ? AND  tori_message_in_the_chat.read_status = 0) as numNewMsg from tori_users_list_for_chat LEFT JOIN tori_users ON tori_users.id = tori_users_list_for_chat.id_user_in_list LEFT JOIN tori_user_date ON tori_users.id = tori_user_date.user_id WHERE tori_users_list_for_chat.id_user = ?`+par.status, [par.id_user, par.id_user, par.id_user]);
		} catch (error) {
			return null;
		}
	}

	async getHistoryDialog(par){
		try {
			return await this.db.query(`SELECT * FROM (SELECT tori_users.login, tori_user_date.name, tori_user_date.lastname, tori_user_date.company_name, tori_user_date.company_link, tori_user_date.user_img, tori_message_in_the_chat.id, tori_message_in_the_chat.from_user_id, tori_message_in_the_chat.to_user_id, tori_message_in_the_chat.message, tori_message_in_the_chat.read_status, tori_message_in_the_chat.write_data, DATE_FORMAT(tori_message_in_the_chat.write_data, "%d.%m.%Y %H:%i") as msg_data FROM tori_message_in_the_chat LEFT JOIN tori_users ON tori_users.id = tori_message_in_the_chat.from_user_id LEFT JOIN tori_user_date ON tori_users.id = tori_user_date.user_id WHERE (tori_message_in_the_chat.from_user_id = ? AND tori_message_in_the_chat.to_user_id =?) OR (tori_message_in_the_chat.to_user_id = ? AND tori_message_in_the_chat.from_user_id =?) ORDER BY tori_message_in_the_chat.write_data DESC LIMIT 25) as t ORDER BY t.write_data ASC`, [par.id_user_from, par.id_user_to, par.id_user_from, par.id_user_to]);
		} catch (error) {
			return error;
		}
	}
    
    async updateReadStatus(par){
		return await this.db.query(`UPDATE tori_message_in_the_chat SET read_status = 1 WHERE tori_message_in_the_chat.from_user_id = ? AND tori_message_in_the_chat.to_user_id =?`, [par.id_user_to, par.id_user_from]);
	}
    
    async getNewMsgs(par){
		return await this.db.query(`SELECT COUNT(message) as num from tori_message_in_the_chat WHERE tori_message_in_the_chat.from_user_id = ? AND tori_message_in_the_chat.to_user_id = ? AND tori_message_in_the_chat.read_status = 0`, [par.usr_to, par.usr_from]);
	}
    
    async insertMessages(par){
		try {
			return await this.db.query(`insert into tori_message_in_the_chat(from_user_id, to_user_id, message, write_data) values(?, ?, ?, NOW())`, [par.usr_from, par.usr_to, par.msg])
		} catch (error) {
			return null;
		}
	}
    
    async updateUserShowStatus(par){
		try {
			return await this.db.query(`UPDATE tori_users_list_for_chat SET show_status = 0 WHERE tori_users_list_for_chat.id_user = ? AND tori_users_list_for_chat.id_user_in_list = ?`, [par.usr_from, par.usr_to]);
        } catch (error) {
			return null;
		}
	}
    
    async dltUserFromUserlist(par){
		try {
			return await this.db.query(`DELETE FROM tori_users_list_for_chat WHERE tori_users_list_for_chat.id_user = ? AND tori_users_list_for_chat.id_user_in_list = ?`, [par.usr_from, par.usr_to]);
        } catch (error) {
			return null;
		}
	}
    
	async logOutUser(par){
		return await this.db.query(`update tori_users set onlineSatus = 0, socketid = NULL where id = ? and socketid = ?`, [par.id, par.s_id]);
	}
}
module.exports = new Helper();