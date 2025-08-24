# IP Logger Project

This project provides a simple **IP logging and tracking system** using PHP.  
It includes three main files:

## 📂 Files Overview

### 1. `ip_logger.php`
- Captures and logs the client’s IP address, user agent, and request time.
- Stores logs in a structured format (JSON / text file).
- Can be used to track visits and analyze traffic.

### 2. `log.php`
- Displays logged IP records in a readable format.
- Includes filtering and visualization of captured IPs and metadata.
- Provides a basic interface for administrators to check logs.

### 3. `ip_log_beacon.php`
- Works as a lightweight tracking beacon (similar to a pixel tracker).
- Can be embedded in websites or applications to silently log visits.
- Useful for monitoring hidden activity or background tracking.

## 🚀 Features
- Lightweight and simple PHP-based system (no database required).
- Tracks **IP, User Agent, Timestamp**.
- Supports **logging via direct access** and **tracking via beacon**.
- Can be extended to save logs into a database.

## ⚙️ Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/ip-logger.git
   cd ip-logger
   ```

2. Deploy the files on a PHP-enabled server.

3. Ensure the web server has **write permissions** to the directory where logs are stored.

4. Access the logger:
   - Tracking: `https://yourdomain.com/ip_logger.php`
   - Logs Panel: `https://yourdomain.com/log.php`
   - Beacon: Embed `<img src="https://yourdomain.com/ip_log_beacon.php" style="display:none;">`

## 🔒 Security Notes
- Protect `log.php` with authentication (to prevent unauthorized access).
- Store sensitive logs outside the public root if possible.
- Consider using HTTPS to secure transmitted data.

## 📜 License
This project is licensed under the MIT License.
