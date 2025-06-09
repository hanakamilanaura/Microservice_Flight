const db = require("../../config/db");

const custSupportResolvers = {
  Query: {
    getAllTickets: () => {
      return new Promise((resolve, reject) => {
        db.query("SELECT * FROM support_tickets", (err, results) => {
          if (err) reject(err);
          resolve(results);
        });
      });
    },
    getTicketById: (_, { id }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM support_tickets WHERE ticket_id = ?",
          [id],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    getTicketsByUserId: (_, { userId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM support_tickets WHERE user_id = ?",
          [userId],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getTicketsByStatus: (_, { status }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM support_tickets WHERE status = ?",
          [status],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getTicketsByPriority: (_, { priority }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM support_tickets WHERE priority = ?",
          [priority],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getTicketResponses: (_, { ticketId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM support_responses WHERE ticket_id = ? ORDER BY created_at ASC",
          [ticketId],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
  },

  Mutation: {
    createTicket: (_, { user_id, subject, description, priority, category }) => {
      return new Promise((resolve, reject) => {
        const now = new Date().toISOString();
        const query =
          "INSERT INTO support_tickets (user_id, subject, description, status, priority, created_at, updated_at, category) VALUES (?, ?, ?, 'OPEN', ?, ?, ?, ?)";
        db.query(
          query,
          [user_id, subject, description, priority, now, now, category],
          (err, results) => {
            if (err) reject(err);
            resolve({
              ticket_id: results.insertId,
              user_id,
              subject,
              description,
              status: 'OPEN',
              priority,
              created_at: now,
              updated_at: now,
              category,
            });
          }
        );
      });
    },
    updateTicket: (_, { id, subject, description, status, priority, category, assigned_to }) => {
      return new Promise((resolve, reject) => {
        const updates = [];
        const values = [];
        
        if (subject !== undefined) {
          updates.push("subject = ?");
          values.push(subject);
        }
        if (description !== undefined) {
          updates.push("description = ?");
          values.push(description);
        }
        if (status !== undefined) {
          updates.push("status = ?");
          values.push(status);
        }
        if (priority !== undefined) {
          updates.push("priority = ?");
          values.push(priority);
        }
        if (category !== undefined) {
          updates.push("category = ?");
          values.push(category);
        }
        if (assigned_to !== undefined) {
          updates.push("assigned_to = ?");
          values.push(assigned_to);
        }

        if (updates.length === 0) {
          reject("No fields to update");
          return;
        }

        updates.push("updated_at = ?");
        values.push(new Date().toISOString());
        values.push(id);

        const query = `UPDATE support_tickets SET ${updates.join(", ")} WHERE ticket_id = ?`;
        
        db.query(query, values, (err, results) => {
          if (err) reject("Update failed");
          if (results.affectedRows === 0) reject("Ticket not found");
          resolve("Ticket updated successfully");
        });
      });
    },
    addResponse: (_, { ticket_id, user_id, message, is_staff }) => {
      return new Promise((resolve, reject) => {
        const now = new Date().toISOString();
        const query =
          "INSERT INTO support_responses (ticket_id, user_id, message, created_at, is_staff) VALUES (?, ?, ?, ?, ?)";
        db.query(
          query,
          [ticket_id, user_id, message, now, is_staff],
          (err, results) => {
            if (err) reject(err);
            resolve({
              response_id: results.insertId,
              ticket_id,
              user_id,
              message,
              created_at: now,
              is_staff,
            });
          }
        );
      });
    },
    closeTicket: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const now = new Date().toISOString();
        const query = "UPDATE support_tickets SET status = 'CLOSED', updated_at = ? WHERE ticket_id = ?";
        db.query(query, [now, id], (err, results) => {
          if (err) reject("Closure failed");
          if (results.affectedRows === 0) reject("Ticket not found");
          resolve("Ticket closed successfully");
        });
      });
    },
    deleteTicket: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const query = "DELETE FROM support_tickets WHERE ticket_id = ?";
        db.query(query, [id], (err, results) => {
          if (err) reject("Delete failed");
          if (results.affectedRows === 0) reject("Ticket not found");
          resolve("Ticket deleted successfully");
        });
      });
    },
  },
};

module.exports = custSupportResolvers;