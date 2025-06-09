const { gql } = require("apollo-server-express");

const userTypeDefs = gql`
  type User {
    user_id: ID!
    username: String!
    email: String!
    password: String!
    full_name: String!
    phone_number: String
    address: String
    role: String!
    created_at: String!
    updated_at: String!
    last_login: String
    status: String!
  }

  type UserProfile {
    profile_id: ID!
    user_id: ID!
    date_of_birth: String
    nationality: String
    passport_number: String
    emergency_contact: String
    preferences: String
  }

  type Query {
    getAllUsers: [User]
    getUserById(id: ID!): User
    getUserByEmail(email: String!): User
    getUserProfile(userId: ID!): UserProfile
    searchUsers(searchTerm: String!): [User]
  }

  type Mutation {
    createUser(
      username: String!
      email: String!
      password: String!
      full_name: String!
      phone_number: String
      address: String
      role: String!
    ): User

    updateUser(
      id: ID!
      username: String
      email: String
      password: String
      full_name: String
      phone_number: String
      address: String
      role: String
      status: String
    ): String

    updateUserProfile(
      user_id: ID!
      date_of_birth: String
      nationality: String
      passport_number: String
      emergency_contact: String
      preferences: String
    ): UserProfile

    deleteUser(id: ID!): String
    deactivateUser(id: ID!): String
    reactivateUser(id: ID!): String
  }
`;

module.exports = userTypeDefs;