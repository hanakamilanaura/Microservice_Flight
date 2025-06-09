const db = require("../../config/db");
const bcrypt = require("bcrypt");

const userResolvers = {
  Query: {
    getAllUsers: () => {
      return new Promise((resolve, reject) => {
        db.query("SELECT * FROM users", (err, results) => {
          if (err) reject(err);
          resolve(results);
        });
      });
    },
    getUserById: (_, { id }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM users WHERE user_id = ?",
          [id],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    getUserByEmail: (_, { email }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM users WHERE email = ?",
          [email],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    getUserProfile: (_, { userId }) => {
      return new Promise((resolve, reject) => {
        db.query(
          "SELECT * FROM user_profiles WHERE user_id = ?",
          [userId],
          (err, results) => {
            if (err) reject(err);
            resolve(results[0]);
          }
        );
      });
    },
    searchUsers: (_, { searchTerm }) => {
      return new Promise((resolve, reject) => {
        const searchPattern = `%${searchTerm}%`;
        db.query(
          `SELECT * FROM users 
           WHERE username LIKE ? 
           OR email LIKE ? 
           OR full_name LIKE ?`,
          [searchPattern, searchPattern, searchPattern],
          (err, results) => {
            if (err) reject(err);
            resolve(results);
          }
        );
      });
    },
  },

  Mutation: {
    createUser: async (_, { username, email, password, full_name, phone_number, address, role }) => {
      return new Promise(async (resolve, reject) => {
        try {
          // Hash the password
          const hashedPassword = await bcrypt.hash(password, 10);
          const now = new Date().toISOString();

          const query =
            "INSERT INTO users (username, email, password, full_name, phone_number, address, role, created_at, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'ACTIVE')";
          
          db.query(
            query,
            [username, email, hashedPassword, full_name, phone_number, address, role, now, now],
            (err, results) => {
              if (err) reject(err);
              resolve({
                user_id: results.insertId,
                username,
                email,
                password: hashedPassword,
                full_name,
                phone_number,
                address,
                role,
                created_at: now,
                updated_at: now,
                status: 'ACTIVE',
              });
            }
          );
        } catch (error) {
          reject(error);
        }
      });
    },
    updateUser: async (_, { id, username, email, password, full_name, phone_number, address, role, status }) => {
      return new Promise(async (resolve, reject) => {
        try {
          const updates = [];
          const values = [];
          
          if (username !== undefined) {
            updates.push("username = ?");
            values.push(username);
          }
          if (email !== undefined) {
            updates.push("email = ?");
            values.push(email);
          }
          if (password !== undefined) {
            const hashedPassword = await bcrypt.hash(password, 10);
            updates.push("password = ?");
            values.push(hashedPassword);
          }
          if (full_name !== undefined) {
            updates.push("full_name = ?");
            values.push(full_name);
          }
          if (phone_number !== undefined) {
            updates.push("phone_number = ?");
            values.push(phone_number);
          }
          if (address !== undefined) {
            updates.push("address = ?");
            values.push(address);
          }
          if (role !== undefined) {
            updates.push("role = ?");
            values.push(role);
          }
          if (status !== undefined) {
            updates.push("status = ?");
            values.push(status);
          }

          if (updates.length === 0) {
            reject("No fields to update");
            return;
          }

          updates.push("updated_at = ?");
          values.push(new Date().toISOString());
          values.push(id);

          const query = `UPDATE users SET ${updates.join(", ")} WHERE user_id = ?`;
          
          db.query(query, values, (err, results) => {
            if (err) reject("Update failed");
            if (results.affectedRows === 0) reject("User not found");
            resolve("User updated successfully");
          });
        } catch (error) {
          reject(error);
        }
      });
    },
    updateUserProfile: (_, { user_id, date_of_birth, nationality, passport_number, emergency_contact, preferences }) => {
      return new Promise((resolve, reject) => {
        const updates = [];
        const values = [];
        
        if (date_of_birth !== undefined) {
          updates.push("date_of_birth = ?");
          values.push(date_of_birth);
        }
        if (nationality !== undefined) {
          updates.push("nationality = ?");
          values.push(nationality);
        }
        if (passport_number !== undefined) {
          updates.push("passport_number = ?");
          values.push(passport_number);
        }
        if (emergency_contact !== undefined) {
          updates.push("emergency_contact = ?");
          values.push(emergency_contact);
        }
        if (preferences !== undefined) {
          updates.push("preferences = ?");
          values.push(preferences);
        }

        if (updates.length === 0) {
          reject("No fields to update");
          return;
        }

        values.push(user_id);

        // Check if profile exists
        db.query("SELECT * FROM user_profiles WHERE user_id = ?", [user_id], (err, results) => {
          if (err) {
            reject(err);
            return;
          }

          if (results.length === 0) {
            // Create new profile
            const query = "INSERT INTO user_profiles (user_id, date_of_birth, nationality, passport_number, emergency_contact, preferences) VALUES (?, ?, ?, ?, ?, ?)";
            db.query(
              query,
              [user_id, date_of_birth, nationality, passport_number, emergency_contact, preferences],
              (err, results) => {
                if (err) reject(err);
                resolve({
                  profile_id: results.insertId,
                  user_id,
                  date_of_birth,
                  nationality,
                  passport_number,
                  emergency_contact,
                  preferences,
                });
              }
            );
          } else {
            // Update existing profile
            const query = `UPDATE user_profiles SET ${updates.join(", ")} WHERE user_id = ?`;
            db.query(query, values, (err, results) => {
              if (err) reject("Update failed");
              resolve({
                profile_id: results[0].profile_id,
                user_id,
                date_of_birth,
                nationality,
                passport_number,
                emergency_contact,
                preferences,
              });
            });
          }
        });
      });
    },
    deleteUser: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const query = "DELETE FROM users WHERE user_id = ?";
        db.query(query, [id], (err, results) => {
          if (err) reject("Delete failed");
          if (results.affectedRows === 0) reject("User not found");
          resolve("User deleted successfully");
        });
      });
    },
    deactivateUser: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const now = new Date().toISOString();
        const query = "UPDATE users SET status = 'INACTIVE', updated_at = ? WHERE user_id = ?";
        db.query(query, [now, id], (err, results) => {
          if (err) reject("Deactivation failed");
          if (results.affectedRows === 0) reject("User not found");
          resolve("User deactivated successfully");
        });
      });
    },
    reactivateUser: (_, { id }) => {
      return new Promise((resolve, reject) => {
        const now = new Date().toISOString();
        const query = "UPDATE users SET status = 'ACTIVE', updated_at = ? WHERE user_id = ?";
        db.query(query, [now, id], (err, results) => {
          if (err) reject("Reactivation failed");
          if (results.affectedRows === 0) reject("User not found");
          resolve("User reactivated successfully");
        });
      });
    },
  },
};

module.exports = userResolvers;