const { gql } = require("apollo-server-express");

const custSupportTypeDefs = gql`
  type SupportTicket {
    ticket_id: ID!
    user_id: Int!
    subject: String!
    description: String!
    status: String!
    priority: String!
    created_at: String!
    updated_at: String!
    assigned_to: Int
    category: String!
  }

  type SupportResponse {
    response_id: ID!
    ticket_id: ID!
    user_id: Int!
    message: String!
    created_at: String!
    is_staff: Boolean!
  }

  type Query {
    getAllTickets: [SupportTicket]
    getTicketById(id: ID!): SupportTicket
    getTicketsByUserId(userId: ID!): [SupportTicket]
    getTicketsByStatus(status: String!): [SupportTicket]
    getTicketsByPriority(priority: String!): [SupportTicket]
    getTicketResponses(ticketId: ID!): [SupportResponse]
  }

  type Mutation {
    createTicket(
      user_id: Int!
      subject: String!
      description: String!
      priority: String!
      category: String!
    ): SupportTicket

    updateTicket(
      id: ID!
      subject: String
      description: String
      status: String
      priority: String
      category: String
      assigned_to: Int
    ): String

    addResponse(
      ticket_id: ID!
      user_id: Int!
      message: String!
      is_staff: Boolean!
    ): SupportResponse

    closeTicket(id: ID!): String
    deleteTicket(id: ID!): String
  }
`;

module.exports = custSupportTypeDefs;