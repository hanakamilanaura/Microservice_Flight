const db = require("../../config/db");

const bookingResolvers = {
  Query: {
    getAllBookings: () => {
      return new Promise((resolve, reject) => {
        db.query("SELECT * FROM bookings", (err, results) => {
          if (err) reject(err);
          resolve(results);
        });
      });
    },
    getBookingById: (_, { id }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM bookings WHERE booking_id = ?",
          [id],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    getBookingsByUserId: (_, { userId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM bookings WHERE user_id = ?",
          [userId],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getBookingsByFlightId: (_, { flightId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM bookings WHERE flight_id = ?",
          [flightId],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
  },

  Mutation: {
    createBooking: (_, { user_id, flight_id, seat_number, booking_date, status, total_price }) => {
      return new Promise((resolve, reject) => {
        const query =
          "INSERT INTO bookings (user_id, flight_id, seat_number, booking_date, status, total_price) VALUES (?, ?, ?, ?, ?, ?)";
        db.query(
          query,
          [user_id, flight_id, seat_number, booking_date, status, total_price],
          (err, results) => {
            if (err) reject(err);
            resolve({
              booking_id: results.insertId,
              user_id,
              flight_id,
              seat_number,
              booking_date,
              status,
              total_price,
            });
          }
        );
      });
    },
    updateBooking: (_, { id, user_id, flight_id, seat_number, booking_date, status, total_price }) => {
      return new Promise((resolve, reject) => {
        const updates = [];
        const values = [];
        
        if (user_id !== undefined) {
          updates.push("user_id = ?");
          values.push(user_id);
        }
        if (flight_id !== undefined) {
          updates.push("flight_id = ?");
          values.push(flight_id);
        }
        if (seat_number !== undefined) {
          updates.push("seat_number = ?");
          values.push(seat_number);
        }
        if (booking_date !== undefined) {
          updates.push("booking_date = ?");
          values.push(booking_date);
        }
        if (status !== undefined) {
          updates.push("status = ?");
          values.push(status);
        }
        if (total_price !== undefined) {
          updates.push("total_price = ?");
          values.push(total_price);
        }

        if (updates.length === 0) {
          reject("No fields to update");
          return;
        }

        values.push(id);
        const query = `UPDATE bookings SET ${updates.join(", ")} WHERE booking_id = ?`;
        
        db.query(query, values, (err, results) => {
          if (err) reject("Update failed");
          if (results.affectedRows === 0) reject("Booking not found");
          resolve("Booking updated successfully");
        });
      });
    },
    cancelBooking: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const query = "UPDATE bookings SET status = 'CANCELLED' WHERE booking_id = ?";
        db.query(query, [id], (err, results) => {
          if (err) reject("Cancellation failed");
          if (results.affectedRows === 0) reject("Booking not found");
          resolve("Booking cancelled successfully");
        });
      });
    },
    deleteBooking: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const query = "DELETE FROM bookings WHERE booking_id = ?";
        db.query(query, [id], (err, results) => {
          if (err) reject("Delete failed");
          if (results.affectedRows === 0) reject("Booking not found");
          resolve("Booking deleted successfully");
        });
      });
    },
  },
};

module.exports = bookingResolvers;