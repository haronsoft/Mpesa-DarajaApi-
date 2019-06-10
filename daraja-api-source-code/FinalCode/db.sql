-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 31, 2018 at 03:49 PM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m_pesa_payments`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountbalance`
--

CREATE TABLE `accountbalance` (
  `accountBalID` int(11) NOT NULL,
  `WorkingAccount` varchar(20) NOT NULL,
  `FloatAccount` varchar(20) NOT NULL,
  `UtilityAccount` varchar(20) NOT NULL,
  `ChargesPaidAccount` varchar(20) NOT NULL,
  `OrganizationSettlementAccount` varchar(20) NOT NULL,
  `BOCompletedTime` varchar(50) NOT NULL,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `b2b_api_response`
--

CREATE TABLE `b2b_api_response` (
  `b2bTransactionID` int(11) NOT NULL,
  `TransactionID` varchar(20) NOT NULL,
  `InitiatorAccountCurrentBalance` varchar(20) NOT NULL,
  `DebitAccountCurrentBalance` varchar(20) NOT NULL,
  `Amount` varchar(20) NOT NULL,
  `DebitPartyAffectedAccountBalance` varchar(20) NOT NULL,
  `TransCompletedTime` varchar(20) NOT NULL,
  `DebitPartyCharges` varchar(20) NOT NULL,
  `ReceiverPartyPublicName` varchar(50) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `UpdatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `b2c_api_response`
--

CREATE TABLE `b2c_api_response` (
  `b2bID` int(11) NOT NULL,
  `TransactionReceipt` varchar(15) NOT NULL,
  `TransactionAmount` varchar(10) NOT NULL,
  `B2CWorkingAccountAvailableFunds` varchar(10) NOT NULL,
  `B2CUtilityAccountAvailableFunds` varchar(10) NOT NULL,
  `TransactionCompletedDateTime` varchar(20) NOT NULL,
  `ReceiverPartyPublicName` varchar(30) NOT NULL,
  `B2CChargesPaidAccountAvailableFunds` varchar(10) NOT NULL,
  `B2CRecipientIsRegisteredCustomer` varchar(2) NOT NULL,
  `UpdatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `lnmo_api_response`
--

CREATE TABLE `lnmo_api_response` (
  `lnmoID` int(11) NOT NULL,
  `Amount` varchar(20) NOT NULL,
  `MpesaReceiptNumber` varchar(20) NOT NULL,
  `TransactionDate` varchar(20) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `updateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `mobile_payments`
--

CREATE TABLE `mobile_payments` (
  `transLoID` int(11) NOT NULL,
  `TransactionType` varchar(10) NOT NULL,
  `TransID` varchar(10) NOT NULL,
  `TransTime` varchar(14) NOT NULL,
  `TransAmount` double NOT NULL,
  `BusinessShortCode` varchar(6) NOT NULL,
  `BillRefNumber` varchar(200) NOT NULL,
  `InvoiceNumber` varchar(6) NOT NULL,
  `OrgAccountBalance` varchar(10) NOT NULL,
  `ThirdPartyTransID` varchar(10) NOT NULL,
  `MSISDN` varchar(14) NOT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `MiddleName` varchar(10) DEFAULT NULL,
  `LastName` varchar(10) DEFAULT NULL,
  `lastUpdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `reverse_transaction`
--

CREATE TABLE `reverse_transaction` (
  `transactionstatusID` int(11) NOT NULL,
  `DebitAccountBalance` varchar(25) NOT NULL,
  `Amount` varchar(20) NOT NULL,
  `TransCompletedTime` varchar(25) NOT NULL,
  `OriginalTransactionID` varchar(20) NOT NULL,
  `Charge` varchar(20) NOT NULL,
  `CreditPartyPublicName` varchar(50) NOT NULL,
  `DebitPartyPublicName` varchar(50) NOT NULL,
  `updateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_status`
--

CREATE TABLE `transaction_status` (
  `transactionStatusID` int(11) NOT NULL,
  `ReceiptNo` varchar(20) NOT NULL,
  `ConversationID` varchar(50) NOT NULL,
  `FinalisedTime` varchar(25) NOT NULL,
  `Amount` varchar(20) NOT NULL,
  `TransactionStatus` varchar(20) NOT NULL,
  `ReasonType` varchar(50) NOT NULL,
  `DebitPartyCharges` varchar(20) NOT NULL,
  `DebitAccountType` varchar(20) NOT NULL,
  `InitiatedTime` varchar(20) NOT NULL,
  `OriginatorConversationID` varchar(20) NOT NULL,
  `CreditPartyName` varchar(55) NOT NULL,
  `DebitPartyName` varchar(50) NOT NULL,
  `updatedTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountbalance`
--
ALTER TABLE `accountbalance`
  ADD PRIMARY KEY (`accountBalID`);

--
-- Indexes for table `b2b_api_response`
--
ALTER TABLE `b2b_api_response`
  ADD PRIMARY KEY (`b2bTransactionID`);

--
-- Indexes for table `b2c_api_response`
--
ALTER TABLE `b2c_api_response`
  ADD PRIMARY KEY (`b2bID`);

--
-- Indexes for table `lnmo_api_response`
--
ALTER TABLE `lnmo_api_response`
  ADD PRIMARY KEY (`lnmoID`);

--
-- Indexes for table `mobile_payments`
--
ALTER TABLE `mobile_payments`
  ADD PRIMARY KEY (`transLoID`),
  ADD UNIQUE KEY `TransID` (`TransID`);

--
-- Indexes for table `reverse_transaction`
--
ALTER TABLE `reverse_transaction`
  ADD PRIMARY KEY (`transactionstatusID`);

--
-- Indexes for table `transaction_status`
--
ALTER TABLE `transaction_status`
  ADD PRIMARY KEY (`transactionStatusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountbalance`
--
ALTER TABLE `accountbalance`
  MODIFY `accountBalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `b2b_api_response`
--
ALTER TABLE `b2b_api_response`
  MODIFY `b2bTransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `b2c_api_response`
--
ALTER TABLE `b2c_api_response`
  MODIFY `b2bID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lnmo_api_response`
--
ALTER TABLE `lnmo_api_response`
  MODIFY `lnmoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mobile_payments`
--
ALTER TABLE `mobile_payments`
  MODIFY `transLoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reverse_transaction`
--
ALTER TABLE `reverse_transaction`
  MODIFY `transactionstatusID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_status`
--
ALTER TABLE `transaction_status`
  MODIFY `transactionStatusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
