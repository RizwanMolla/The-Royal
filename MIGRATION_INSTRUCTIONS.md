# Database Migration Instructions

## Add Cancellation Status Feature

To enable the cancellation request feature, you need to add the `cancellation_status` column to the bookings table.

### Option 1: Using MySQL Command Line

```bash
mysql -u root -p the_royal < add_cancellation_status.sql
```

### Option 2: Using phpMyAdmin

1. Open phpMyAdmin
2. Select the `the_royal` database
3. Click on the "SQL" tab
4. Copy and paste the contents of `add_cancellation_status.sql`
5. Click "Go" to execute

### Option 3: Manual SQL Execution

Run these SQL commands in your MySQL client:

```sql
USE the_royal;

ALTER TABLE bookings
ADD COLUMN cancellation_status ENUM('none', 'requested', 'approved', 'rejected') DEFAULT 'none' AFTER status;

ALTER TABLE bookings
ADD INDEX idx_cancellation_status (cancellation_status);
```

### Verify Installation

After running the migration, verify it worked by running:

```sql
DESCRIBE bookings;
```

You should see the `cancellation_status` column in the table structure.

### What This Adds

- Users can request booking cancellations
- Admins can approve or reject cancellation requests
- Approved cancellations make rooms available again
- Status tracking for all cancellation requests
