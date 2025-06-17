const { ApolloServer, gql } = require('apollo-server');
const mysql = require('mysql2');

// Koneksi ke database MySQL
const connection = mysql.createConnection({
  host: '127.0.0.1',  
  port: 3306,        
  user: 'root',      
  password: '', 
  database: 'db_user' 
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting to the database:', err);
    return;
  }
  console.log('Connected to MySQL database!');
});

// Schema GraphQL
const typeDefs = gql`
  type Query {
    users: [User]
    user(id: ID!): User
  }

  type User {
    id: ID
    name: String
    email: String
  }
`;

// Resolvers untuk mengambil data dari MySQL
const resolvers = {
  Query: {
    users: async () => {
      // data pengguna dari MySQL
      return new Promise((resolve, reject) => {
        connection.query('SELECT * FROM users', (err, results) => {
          if (err) {
            reject(err);
          }
          resolve(results);
        });
      });
    },
    user: async (parent, args) => {
      // data pengguna berdasarkan ID dari MySQL
      return new Promise((resolve, reject) => {
        connection.query(
          'SELECT * FROM users WHERE id = ?',
          [args.id],
          (err, results) => {
            if (err) {
              reject(err);
            }
            resolve(results[0]);  
          }
        );
      });
    }
  }
};

// server Apollo
const server = new ApolloServer({ typeDefs, resolvers });

server.listen({ port: 90001 }).then(({ url }) => {
  console.log(`Server ready at ${url}`);
});
