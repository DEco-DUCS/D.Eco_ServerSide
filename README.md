# D.Eco_ServerSide

This repository is for the back-end part of the D.Eco project. The application is for Drury University users who want to view trees on campus. The ServerSide repository stores the SQL script that contains the information of the 500 trees on campus, the php script to get the JSON object from the MySQL DB, and the php script that creates the Admin Website.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

Download Software:
* MySQLWorkbench - https://dev.mysql.com/downloads/workbench/
* A php editor (Atom) - https://atom.io/
* MAMP (Mac) - https://www.mamp.info/en/downloads/
  * (no need for MAMP Pro)
* XAMPP (Windows) - https://www.apachefriends.org/index.html

Technology:
* Currently the backend is on Amazon Web Services (AWS) but it will all be moved to a serve on Drury's campus
  * AWS - https://console.aws.amazon.com/console/home

### Setting Up Environment

#### Running PHP Script
1. Put PHP code in /Applications/MAMP/htdocs
2. Start MAMP MySQL and Apache server
3. Visit http://localhost:8888/ to see running PHP script

#### Database Structure
* Get database login information from Drury Web Administrator
* Tables
  * admin - contains username and password login information for access to the Admin Website
  * imageTable - contains imageID (primary key), treeID (foriegn key), filepath (to image in server), and title
  * trees - contains the information for the 21 trees tour
  * treesTable - contains the informations for the 500+ tree on Drury's campus
   * (for any addition information about the trees' information contact Dr. Popescu)

## Deployment

Add additional notes about how to deploy this on a live system


## Authors

* **Kylie Pfaff**
