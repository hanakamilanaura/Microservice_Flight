const db = require("../../config/db");

const flightResolvers = {
  Query: {
    getAllFlights: () => {
      return new Promise((resolve, reject) => {
        db.query("SELECT * FROM flights", (err, results) => {
          if (err) reject(err);
          resolve(results);
        });
      });
    },
    getFlightById: (_, { id }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM flights WHERE flight_id = ?",
          [id],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    getFlightsByRoute: (_, { departure, arrival }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM flights WHERE departure_airport = ? AND arrival_airport = ?",
          [departure, arrival],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getFlightsByDate: (_, { date }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM flights WHERE DATE(departure_time) = ?",
          [date],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    getAvailableSeats: (_, { flightId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM seats WHERE flight_id = ? AND is_available = true",
          [flightId],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
    searchFlights: (_, { departure, arrival, date, passengers }) => {
      return new Promise((resolve, reject) => {
        db.query(
          `SELECT f.* FROM flights f 
           WHERE f.departure_airport = ? 
           AND f.arrival_airport = ? 
           AND DATE(f.departure_time) = ?
           AND f.available_seats >= ?
           AND f.status = 'SCHEDULED'`,
          [departure, arrival, date, passengers],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
  },

  Mutation: {
    createFlight: (_, { flight_number, airline, departure_airport, arrival_airport, departure_time, arrival_time, total_seats, price, aircraft_type }) => {
      return new Promise((resolve, reject) => {
        const query =
          "INSERT INTO flights (flight_number, airline, departure_airport, arrival_airport, departure_time, arrival_time, total_seats, available_seats, price, status, aircraft_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'SCHEDULED', ?)";
        db.query(
          query,
          [flight_number, airline, departure_airport, arrival_airport, departure_time, arrival_time, total_seats, total_seats, price, aircraft_type],
          (err, results) => {
            if (err) reject(err);
            resolve({
              flight_id: results.insertId,
              flight_number,
              airline,
              departure_airport,
              arrival_airport,
              departure_time,
              arrival_time,
              total_seats,
              available_seats: total_seats,
              price,
              status: 'SCHEDULED',
              aircraft_type,
            });
          }
        );
      });
    },
    updateFlight: (_, { id, flight_number, airline, departure_airport, arrival_airport, departure_time, arrival_time, total_seats, price, status, aircraft_type }) => {
      return new Promise((resolve, reject) => {
        const updates = [];
        const values = [];
        
        if (flight_number !== undefined) {
          updates.push("flight_number = ?");
          values.push(flight_number);
        }
        if (airline !== undefined) {
          updates.push("airline = ?");
          values.push(airline);
        }
        if (departure_airport !== undefined) {
          updates.push("departure_airport = ?");
          values.push(departure_airport);
        }
        if (arrival_airport !== undefined) {
          updates.push("arrival_airport = ?");
          values.push(arrival_airport);
        }
        if (departure_time !== undefined) {
          updates.push("departure_time = ?");
          values.push(departure_time);
        }
        if (arrival_time !== undefined) {
          updates.push("arrival_time = ?");
          values.push(arrival_time);
        }
        if (total_seats !== undefined) {
          updates.push("total_seats = ?");
          values.push(total_seats);
        }
        if (price !== undefined) {
          updates.push("price = ?");
          values.push(price);
        }
        if (status !== undefined) {
          updates.push("status = ?");
          values.push(status);
        }
        if (aircraft_type !== undefined) {
          updates.push("aircraft_type = ?");
          values.push(aircraft_type);
        }

        if (updates.length === 0) {
          reject("No fields to update");
          return;
        }

        values.push(id);
        const query = `UPDATE flights SET ${updates.join(", ")} WHERE flight_id = ?`;
        
        db.query(query, values, (err, results) => {
          if (err) reject("Update failed");
          if (results.affectedRows === 0) reject("Flight not found");
          resolve("Flight updated successfully");
        });
      });
    },
    updateFlightStatus: (_, { id, status }) => {
      return new Promise((resolve, reject) => {
        const query = "UPDATE flights SET status = ? WHERE flight_id = ?";
        db.query(query, [status, id], (err, results) => {
          if (err) reject("Status update failed");
          if (results.affectedRows === 0) reject("Flight not found");
          resolve("Flight status updated successfully");
        });
      });
    },
    deleteFlight: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const query = "DELETE FROM flights WHERE flight_id = ?";
        db.query(query, [id], (err, results) => {
          if (err) reject("Delete failed");
          if (results.affectedRows === 0) reject("Flight not found");
          resolve("Flight deleted successfully");
        });
      });
    },
    addSeat: (_, { flight_id, seat_number, class: seatClass, price_multiplier }) => {
      return new Promise((resolve, reject) => {
        const query =
          "INSERT INTO seats (flight_id, seat_number, class, is_available, price_multiplier) VALUES (?, ?, ?, true, ?)";
        db.query(
          query,
          [flight_id, seat_number, seatClass, price_multiplier],
          (err, results) => {
            if (err) reject(err);
            resolve({
              seat_id: results.insertId,
              flight_id,
              seat_number,
              class: seatClass,
              is_available: true,
              price_multiplier,
            });
          }
        );
      });
    },
    updateSeatAvailability: (_, { seat_id, is_available }) => {
      return new Promise((resolve, reject) => {
        const query = "UPDATE seats SET is_available = ? WHERE seat_id = ?";
        db.query(query, [is_available, seat_id], (err, results) => {
          if (err) reject("Availability update failed");
          if (results.affectedRows === 0) reject("Seat not found");
          resolve("Seat availability updated successfully");
        });
      });
    },
  },
};

module.exports = flightResolvers;