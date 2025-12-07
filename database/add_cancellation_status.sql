-- Add cancellation_status column to bookings table
ALTER TABLE bookings 
ADD COLUMN cancellation_status ENUM('none', 'requested', 'approved', 'rejected') DEFAULT 'none' AFTER status;

-- Add index for cancellation_status
ALTER TABLE bookings 
ADD INDEX idx_cancellation_status (cancellation_status);
