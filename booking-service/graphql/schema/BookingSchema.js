const { gql } = require("apollo-server-express");

const bookingTypeDefs = gql`
  type Booking {
    booking_id: ID!
    user_id: Int!
    flight_id: Int!
    seat_number: String!
    booking_date: String!
    status: String!
    total_price: Float!
  }

  type Query {
    getAllBookings: [Booking]
    getBookingById(id: ID!): Booking
    getBookingsByUserId(userId: ID!): [Booking]
    getBookingsByFlightId(flightId: ID!): [Booking]
  }

  type Mutation {
    createBooking(
      user_id: Int!
      flight_id: Int!
      seat_number: String!
      booking_date: String!
      status: String!
      total_price: Float!
    ): Booking
    
    updateBooking(
      id: ID!
      user_id: Int
      flight_id: Int
      seat_number: String
      booking_date: String
      status: String
      total_price: Float
    ): String
    
    cancelBooking(id: ID!): String
    deleteBooking(id: ID!): String
  }
`;

module.exports = bookingTypeDefs;