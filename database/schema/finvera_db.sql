-- ===================================================
-- DATABASE: Finvera Loan System
-- Author: Bayu Satrio Wibowo
-- Telkom University | IF-47-12
-- ===================================================

CREATE DATABASE IF NOT EXISTS finvera_db;
USE finvera_db;

-- ===================================================
-- 1. USERS
-- ===================================================
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    phone_number VARCHAR(20),
    date_of_birth DATE,
    address TEXT,
    occupation VARCHAR(100),
    monthly_income DECIMAL(15,2),
    credit_score INT DEFAULT 500,
    role ENUM('admin', 'borrower') DEFAULT 'borrower',
    status ENUM('active', 'inactive', 'suspended', 'blacklisted') DEFAULT 'active',
    kyc_status ENUM('not_verified', 'pending', 'verified', 'rejected') DEFAULT 'not_verified',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ===================================================
-- 2. KYC_VERIFICATIONS
-- ===================================================
CREATE TABLE kyc_verifications (
    verification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    id_card_number VARCHAR(50),
    id_card_image VARCHAR(255),
    selfie_with_id_image VARCHAR(255),
    status ENUM('pending', 'verified', 'rejected', 'expired') DEFAULT 'pending',
    verified_by INT,
    verified_at DATETIME,
    expires_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (verified_by) REFERENCES users(user_id)
);

-- ===================================================
-- 3. LOAN_PRODUCTS
-- ===================================================
CREATE TABLE loan_products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_type ENUM('payday', 'installment', 'micro', 'mortgage', 'business'),
    description TEXT,
    min_amount DECIMAL(15,2),
    max_amount DECIMAL(15,2),
    min_tenor INT,
    max_tenor INT,
    late_fee_percentage DECIMAL(5,2),
    eligibility_criteria JSON,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- ===================================================
-- 4. LOAN_APPLICATIONS
-- ===================================================
CREATE TABLE loan_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    purpose TEXT,
    amount DECIMAL(15,2),
    tenor INT,
    proofing_type_loan VARCHAR(255),
    kyc_verification_id INT,
    credit_score_at_application INT,
    status ENUM('draft', 'pending', 'under_review', 'approved', 'rejected') DEFAULT 'draft',
    application_date DATETIME,
    max_amount DECIMAL(15,2) DEFAULT 1000000,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES loan_products(product_id),
    FOREIGN KEY (kyc_verification_id) REFERENCES kyc_verifications(verification_id)
);

-- ===================================================
-- 5. LOANS
-- ===================================================
CREATE TABLE loans (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_number VARCHAR(50) UNIQUE,
    user_id INT,
    product_id INT,
    amount DECIMAL(15,2),
    tenor INT,
    purpose TEXT,
    status ENUM('pending', 'approved', 'rejected', 'disbursed', 'active', 'completed', 'defaulted') DEFAULT 'pending',
    application_date DATETIME,
    approval_date DATETIME,
    disbursement_date DATETIME,
    due_date DATE,
    completed_date DATETIME,
    approved_by INT,
    credit_score_at_application INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES loan_products(product_id),
    FOREIGN KEY (approved_by) REFERENCES users(user_id)
);

-- ===================================================
-- 6. INSTALLMENTS
-- ===================================================
CREATE TABLE installments (
    installment_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT,
    installment_number INT,
    due_date DATE,
    amount DECIMAL(15,2),
    status ENUM('pending', 'paid', 'overdue', 'partial') DEFAULT 'pending',
    paid_amount DECIMAL(15,2),
    paid_date DATETIME,
    late_fee DECIMAL(15,2),
    days_late INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(loan_id)
);

-- ===================================================
-- 7. PAYMENTS
-- ===================================================
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    loan_id INT,
    amount DECIMAL(15,2),
    payment_method ENUM('bank_transfer', 'ewallet', 'virtual_account', 'retail', 'auto_debit'),
    payment_date DATETIME,
    reference_number VARCHAR(100) UNIQUE,
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    verified_by INT,
    verified_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(loan_id),
    FOREIGN KEY (verified_by) REFERENCES users(user_id)
);

-- ===================================================
-- 8. NOTIFICATIONS
-- ===================================================
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    message TEXT,
    notification_type ENUM('system', 'loan_application', 'payment', 'kyc', 'reminder', 'promotion') DEFAULT 'system',
    category ENUM('info', 'warning', 'success', 'error', 'urgent') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    scheduled_at DATETIME,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- ===================================================
-- 9. TERMS_AND_CONDITIONS
-- ===================================================
CREATE TABLE terms_and_conditions (
    term_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content TEXT,
    version VARCHAR(20),
    term_type ENUM('global', 'payday', 'installment', 'micro', 'business', 'mortgage', 'kyc', 'privacy') DEFAULT 'global',
    regulatory_references JSON,
    dps_approval_number VARCHAR(100),
    required_for ENUM('registration', 'loan_application', 'specific_product', 'all'),
    acceptance_required BOOLEAN,
    status ENUM('draft', 'active', 'inactive', 'archived') DEFAULT 'draft',
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- ===================================================
-- 10. USER_TERMS_AND_ACCEPTANCES
-- ===================================================
CREATE TABLE user_terms_and_acceptances (
    acceptance_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    term_id INT,
    ip_address VARCHAR(45),
    acceptance_hash VARCHAR(255),
    accepted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (term_id) REFERENCES terms_and_conditions(term_id)
);

-- ===================================================
-- DONE
-- ===================================================
