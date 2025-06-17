const { ApolloServer, gql } = require('apollo-server');
const mysql = require('mysql2');

// Koneksi ke database MySQL
const connection = mysql.createConnection({
  host: 'flight_db', 
  port: 3306,
  user: 'root',
  password: '',
  database: 'db_flight',
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
    flights: [Flight]
    flight(id: ID!): Flight
  }

  type Flight {
    id: ID
    flight_code: String
    airline_name: String
    departure_time: String
    arrival_time: String
    price: Float
    from: String
    to: String
  }
`;

// Resolvers untuk mengambil data dari MySQL
const resolvers = {
  Query: {
    flights: async () => {
      // data penerbangan dari MySQL
      return new Promise((resolve, reject) => {
        connection.query('SELECT * FROM flights', (err, results) => {
          if (err) {
            reject(err);
          }
          resolve(results);
        });
      });
    },
    flight: async (parent, args) => {
      // data penerbangan berdasarkan ID dari MySQL
      return new Promise((resolve, reject) => {
        connection.query(
          'SELECT * FROM flights WHERE id = ?',
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

//  menjalankan server Apollo
const server = new ApolloServer({ typeDefs, resolvers });

server.listen({ port: 9002 }).then(({ url }) => {
  console.log(`Server ready at ${url}`);
});
