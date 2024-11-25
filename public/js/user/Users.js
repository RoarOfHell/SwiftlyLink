export class User {
    constructor(parameters) {
        
    }

    async get_session_user(){
        try {
            const response = await fetch('https://swiftlylink.ru/api/user', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
            });
    
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
    
            const userData = await response.json();
    
            // Возвращаем данные для дальнейшего использования
            return userData;
        } catch (error) {
            console.error('Error fetching user data:', error);
        }
    }

    static setOnline(){
       
        fetch('https://swiftlylink.ru/api/set_online', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        .catch(error => console.error(error));
    }

    static async setOffline() {
        try {
            const response = await fetch('https://swiftlylink.ru/api/set_offline', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                },
                keepalive: true // Важный параметр для запросов перед выгрузкой страницы
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            console.error('Error setting user offline:', error);
        }
    }
}