const { ApolloServer, gql } = require('apollo-server');
const mysql = require('mysql2');
require('dotenv').config();

// Koneksi ke database MySQL menggunakan pool
const pool = mysql.createPool({
  host: process.env.DB_HOST,
  port: process.env.DB_PORT,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

pool.getConnection((err, connection) => {
  if (err) {
    console.error('Error connecting to the database:', err);
    return;
  }
  console.log('Connected to MySQL database!');
  connection.release();
});

// Schema GraphQL
const typeDefs = gql`
  type Query {
    bookings: [Booking]
    booking(id: ID!): Booking
  }

  type Booking {
    id: ID
    user_id: Int
    flight_id: Int
    ticket_quantity: Int
    total_price: Float
  }
`;

// Resolvers untuk mengambil data dari MySQL
const resolvers = {
  Query: {
    bookings: async () => {
      // Mengambil semua data booking dari MySQL
      return new Promise((resolve, reject) => {
        pool.query('SELECT * FROM bookings', (err, results) => {
          if (err) {
            reject(err);
          }
          resolve(results);
        });
      });
    },
    booking: async (parent, args) => {
      // Mengambil data booking berdasarkan ID dari MySQL
      return new Promise((resolve, reject) => {
        pool.query(
          'SELECT * FROM bookings WHERE id = ?',
          [args.id],
          (err, results) => {
            if (err) {
              reject(err);
            }
            resolve(results[0]);  // Mengembalikan hanya satu hasil berdasarkan ID
          }
        );
      });
    }
  }
};

// Menjalankan server Apollo
const server = new ApolloServer({ typeDefs, resolvers });

server.listen({ port: 9003 }).then(({ url }) => {
  console.log(`Server ready at ${url}`);
});
