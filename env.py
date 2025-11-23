import mysql.connector

class Banco:
    def conectar(self):
        return mysql.connector.connect(
            host = 'paparella.com.br',
            user = 'paparell_codigomorse',
            password = '@Senai2025',
            database = 'paparell_codigomorse'
        )
    
    def env(self, total):
        conexao = self.conectar()
        cursor = conexao.cursor()
        query = "INSERT INTO morse_iot(morse) VALUES (%s)"
        cursor.execute(query, (total,))
        conexao.commit()
        cursor.close()
        conexao.close()
       

    