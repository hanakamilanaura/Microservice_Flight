const { ApolloServer, gql } = require('apollo-server');
const mysql = require('mysql2');

// Koneksi ke MySQL
const connection = mysql.createConnection({
  host: '127.0.0.1',
  port: 3307,
  user: 'root',
  password: '123',
  database: 'db_user'
});

connection.connect((err) => {
  if (err) {
    console.error('Database connection failed:', err);
    return;
  }
  console.log('Connected to MySQL database!');
});

// Schema
const typeDefs = gql`
  type Query {
    users: [User]
    user(id: ID!): User
  }

    type Mutation {
    createUser(name: String!, email: String!, password: String!): User
  }

  type User {
    id: ID
    name: String
    email: String
  }
`;

// Resolvers
const resolvers = {
  Query: {
    users: async () => {
      return new Promise((resolve, reject) => {
        connection.query('SELECT * FROM users', (err, results) => {
          if (err) reject(err);
          resolve(results);
        });
      });
    },
    user: async (_, args) => {
      return new Promise((resolve, reject) => {
        connection.query('SELECT * FROM users WHERE id = ?', [args.id], (err, results) => {
          if (err) reject(err);
          if (results.length === 0) {
            return reject(new Error(`Data user dengan ID ${args.id} tidak ada.`));
          } else {
            resolve(results[0]);
          }
        });
      });
    }
  },
  Mutation: {
    createUser: async (_, args) => {
      return new Promise((resolve, reject) => {
        const { name, email, password } = args;

        connection.query(
          'INSERT INTO users (name, email, password) VALUES (?, ?, ?)',
          [name, email, password],
          (err, result) => {
            if (err) {
              console.error("Insert error:", err);
              return reject(err);
            }

            const insertedId = result.insertId;
            if (!insertedId) {
              return reject(new Error('Gagal mendapatkan insertId'));
            }

            connection.query(
              'SELECT id, name, email FROM users WHERE id = ?',
              [insertedId],
              (err2, rows) => {
                if (err2) {
                  return reject(err2);
                }
                resolve(rows[0]);
              }
            );
          }
        );
      });
    }
  } 
};

// Server start
const server = new ApolloServer({ typeDefs, resolvers });

server.listen({ port: 9001 }).then(({ url }) => {
  console.log(`🚀 Server ready at ${url}`);
});