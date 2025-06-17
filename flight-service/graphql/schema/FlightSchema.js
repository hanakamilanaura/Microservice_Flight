const { gql } = require("apollo-server-express");

const flightTypeDefs = gql`
  type Flight {
    flight_id: ID!
    flight_number: String!
    airline: String!
    departure_airport: String!
    arrival_airport: String!
    departure_time: String!
    arrival_time: String!
    total_seats: Int!
    available_seats: Int!
    price: Float!
    status: String!
    aircraft_type: String!
  }

  type Seat {
    seat_id: ID!
    flight_id: ID!
    seat_number: String!
    class: String!
    is_available: Boolean!
    price_multiplier: Float!
  }

  type Query {
    getAllFlights: [Flight]
    getFlightById(id: ID!): Flight
    getFlightsByRoute(departure: String!, arrival: String!): [Flight]
    getFlightsByDate(date: String!): [Flight]
    getAvailableSeats(flightId: ID!): [Seat]
    searchFlights(
      departure: String!
      arrival: String!
      date: String!
      passengers: Int!
    ): [Flight]
  }

  type Mutation {
    createFlight(
      flight_number: String!
      airline: String!
      departure_airport: String!
      arrival_airport: String!
      departure_time: String!
      arrival_time: String!
      total_seats: Int!
      price: Float!
      aircraft_type: String!
    ): Flight

    updateFlight(
      id: ID!
      flight_number: String
      airline: String
      departure_airport: String
      arrival_airport: String
      departure_time: String
      arrival_time: String
      total_seats: Int
      price: Float
      status: String
      aircraft_type: String
    ): String

    updateFlightStatus(id: ID!, status: String!): String
    deleteFlight(id: ID!): String

    addSeat(
      flight_id: ID!
      seat_number: String!
      class: String!
      price_multiplier: Float!
    ): Seat

    updateSeatAvailability(
      seat_id: ID!
      is_available: Boolean!
    ): String
  }
`;

module.exports = flightTypeDefs;