# Test Plan

I will test 2 features. The ability to import data into the database through CSV files and the ability to view data on a chart on the model page.
Both features will test both the happy and unhappy paths. Tests are automatically conducted when pushed to repository using laravel Actions.

### V-Model assosciation:

Requirement Analysis: The user stories capture the desired functionality from the user's perspective.

System Design: System tests verify the successful import of data from CSV files and error handling. Test scenarios cover both happy and unhappy paths.

Architecture Design: Unit tests validate the app's ability to read imported files, add entries to the database, and handle errors.

Implementation: Not included as we are focusing on testing.

Unit Testing: Unit tests further verify import functionality and error handling.

Integration Testing: Not included as we are focusing on testing.

System Testing: System tests cover viewing data on a chart, choosing timeframes, and error handling for different scenarios.

Acceptance Testing: Done by aligning with the needs and requirements of the client.

Maintenance: Evaluation includes possible and impossible detections, concluding that features work when all tests pass, and identifying areas for improvement.

## Feature 1

### User Story

As a user with elevated access privileges, I want the ability to effortlessly update the database by automatically reading and adding database entries regarding the room’s state as well as the outside temperature when importing a CSV file.

### System tests

**Happy path:** Given that I am a user with elevated access privileges, I want to import data into the database when I select a CSV file and click a button associated with the room.

**Unhappy path:** Given that I am a user with elevated access privileges, I want to receive an error message when there has been an error with importing so that I know what I can do to avoid the error.

#### Test Scenario: Import with the correct format CSV file
- **Expected Result:** Successful import with feedback message "Import successful"
- **Actual Result:** Passed

#### Test Scenario: Import with incorrect format CSV file
- **Expected Result:** Import fails and gives an error indicating the problem.
- **Actual Result:** Passed

#### Test Scenario: Import with a file other than a CSV file
- **Expected Result:** File selector does not let you choose a file other than CSV.
- **Actual Result:** Passed

### Unit tests

**Happy Path**

This test ensures that the ability of the app to correctly read the imported file as well as add a new database to the entries works.

The following test follows the steps:
- Making a temporary CSV file filled with information
- Importing the said file into the database
- Asserting that the database contains these new entries

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/5636738e-ab88-4a40-bcd3-744bdef8e777)

Screenshot of result: 

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/fbafc8e9-7bae-4389-b7ff-7919a03fdac1)

**Unhappy Path**

The following test ensures that the import function throws an error message when an error occurs

The following test follows the steps:
- Making a temporary incorrect CSV file filled with information
- Importing the said file into the database
- Asserting that after the failure of the import, a message error is sent containing relevant information.

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/b44392a6-3aff-4ed5-bd22-866a10beee9d)

Screenshot of result:

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/4e978130-df47-4e21-8873-819912fddab0)

### Evaluation

**Possible detection:**

- Making sure that the import feature works by simulating an import.

**Impossible detection:**

- Making sure data outside temperature data in import is correct according to the timeframe.
- Performance/Import speed

**Conclusion:**

The tests are essential for making sure a core function of importing data into the database works.
It can be concluded that everything works correctly when the feature passes all tests because they go over the entirety of the process.
An area for improvement in the testing would be to also test the performance and speed of the import to ensure a low import time and a pleasant user experience

## Feature 2

### User Story

As a building manager, I want to see a visual representation of temperature and CO2 level data as a line 
graph with a timeframe of my choosing.

### System tests

**Happy path:** Given that I am an authenticated user, I want to view room data when clicking on a thermostat above said room and be able to choose a timeframe of my choice.

**Unhappy path:** Given that I am a user with elevated access privileges, I want to receive an error message indicating that there is no available data when clicking on a room with no data.

#### Test Scenario: Clicking on a room with full data
- **Expected Result:** Successfully visualizes the data in the timeframe of the last available day.
- **Actual Result:** Passed

- #### Test Scenario: Clicking on a room with no data
- **Expected Result:** An error message appears in red font saying "No data available"
- **Actual Result:** Passed

#### Test Scenario: Clicking back on a room chart when on the day timeframe
- **Expected Result:** Successfully visualizes the data for the previous day compared to the currently selected day when there is data available.
- **Actual Result:** Passed

#### Test Scenario: Clicking next on a room chart when on the day timeframe
- **Expected Result:** Successfully visualizes the data for the next day compared to the currently selected day when there is data available.
- **Actual Result:** Passed

#### Test Scenario: Clicking back on a room chart when on the hour timeframe
- **Expected Result:** Successfully visualizes the data for the previous hour compared to the currently selected hour when there is data available.
- **Actual Result:** Passed

#### Test Scenario: Clicking next on a room chart when on the hour timeframe
- **Expected Result:** Successfully visualizes the data for the next hour compared to the currently selected hour when there is data available.
- **Actual Result:** Passed

  #### Test Scenario: Clicking back on a room chart when on the week timeframe
- **Expected Result:** Successfully visualizes the data for the previous week compared to the currently selected week when there is data available.
- **Actual Result:** Passed

#### Test Scenario: Clicking next on a room chart when on the week timeframe
- **Expected Result:** Successfully visualizes the data for the next week compared to the currently selected week when there is data available.
- **Actual Result:** Passed

### Unit tests

**Happy Path**

This test ensures that the application receives the proper data upon request from the model page when showing a chart.

The following test follows the steps:
- Creating a new room
- Creating a new room_time using Factory
- Attempting to receive data upon get request to /model-data/{room_name} URL
- Assuring that data is retrieved

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/4e1f8714-c91d-4f5c-9c0a-86a19a27ad99)

Screenshot of result: 

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/fcc2cd0e-ed35-4bae-ad70-80e30ee03d29)

**Unhappy Path**

The following test ensures that no data is received upon no available data in the database.

The following test follows the steps:
- Making a temporary incorrect CSV file filled with information
- Importing the said file into the database
- Asserting that after the failure of the import, a message error is sent containing relevant information.

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/bdacb484-ee9f-4c34-8742-0974f9b470df)

Screenshot of result:

![image](https://github.com/Damyan03/testingLaravel/assets/112628176/cd0bcd08-0317-445a-ae2c-6b2957360669)

### Evaluation

**Possible detection:**

- Making sure that data retrieval is possible with a specified route.

**Impossible detection:**

- Making sure that data is displayed correctly according to the timeframe selected

**Conclusion:**

The tests provide info regarding the data request info of the model page charts.
It can be concluded that everything works correctly when the feature passes all tests.
An area for improvement in the testing would be to automate the testing of timeframes so that it checks to see whether the correct information is being displayed at any given time because
it is possible that the database might return entries in the incorrect order when using external database services.




