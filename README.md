## 📬 Simple Service Booking System  
Pupose of this app is a basic API-based & Admin managed service booking system using Laravel. The system should allow customers to   register, view services, and make bookings. Admin should be able to manage services and view bookings.  

## 🚀 Getting Started  
### 🛠 Setup Instructions  

#### 1. Clone the repository  
git clone https://github.com/Nazmul-Islam-Akanda/Service-Booking-System.git  
cd Service-Booking-System  

#### 2. Copy .env file  
cp .env.example .env  

#### 3. Update the .env File   

DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=service_booking  
DB_USERNAME=root  
DB_PASSWORD=  

# --- Laravel app key ---  
🔑 Laravel app key will be automatically generated during container startup using:  
Run: php artisan key:generate  

#### 4. Create a database  
Create a database with name service_booking  

#### 6. Running the Application  
Run: composer install  
Run: php artisan migrate  
Run: php artisan db:seed  
Run: php artisan serve  

##### Note  
* Swagger documentation url: http://your-domain.com/api/documentation  
* Unit testing have done only for register api. You can run the unit test by following:  
Run: php artisan test  