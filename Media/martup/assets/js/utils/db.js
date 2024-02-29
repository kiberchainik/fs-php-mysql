/**
* Real Time chatting app
* @author Shashank Tiwari
*/
const mysql = require('mysql2');

class Db {
	constructor(config) {
		this.connection = mysql.createConnection({
			connectionLimit: 100,
			host: 'localhost',
			user: 'urlpyrtf_fs',
			password: '62789242aLEX!',
			database: 'urlpyrtf_fs',
            charset: 'utf8mb4',
			debug: false
		});
	}
	query(sql, args) {
		return new Promise((resolve, reject) => {
			this.connection.query(sql, args, (err, rows) => {
				if (err)
					return reject(err);
				resolve(rows);
			});
		});
	}
	close() {
		return new Promise((resolve, reject) => {
			this.connection.end(err => {
				if (err)
					return reject(err);
				resolve();
			});
		});
	}
}
module.exports = new Db();