
# API Documentation for SCREEN-RECORD-EXTENSION-API

## Introduction

Welcome to the API documentation for Screen-Record-api. This document provides comprehensive information on how to use the API, including sample requests and responses, installation instructions, deployment options, known limitations, contributing guidelines, and contact information.

## Table of Contents
- [API Endpoints](#api-endpoints)
- [Known Limitations](#known-limitations)

- [Contact Information](#contact-information)




## API Endpoints

Here are the available API endpoints:

-    Create a New Video (POST)   
  - Endpoint: `/api/`
  - Description: Create a new user in the system.
  - Request Format:
    - HTTP Method: POST
    - Headers: Content-Type: application/json
	        Accept: application/json
    - Body: JSON object with user details.
    If the response was successful
  - Response Format:
    - StatusCode: 201
    - message:Image has been uploaded successfully
    - status:success
    -data
        -video_name
        -video_size
        -video_length
        -video_path
        -full-date-format
if not successful
- Response Format
    - StatusCode:401,
    - message:An Error occurred while trying to Save
    - status:error
- Response Format
    - StatusCode:400,
    - message:Bad Request an Error Occurred
    - status:error
    ---
-    Fetch Video (GET)   
  - Endpoint: `/api/`
  - Description: Fetch details of videos uploaded
  - Request Format:
    - HTTP Method: GET
  - Response Format:
    - StatusCode: 200 
    - message:Image displayed Successfully
	- status:success
    - data:
        - name:Video_name.mp4
        - size:12.11mb `size of the video in mb`
        - length:3:51 `minute of the video `
        - path:`Path/to/the/video.mp4`
        - uploaded_time:`2023-09-29 20:39:41`
        - full-date-time:`23, september 2023`

## Known Limitations

- The API currently supports a maximum of 100 simultaneous connections. If your application experiences high traffic, consider implementing load balancing.

- Pagination for large result sets is not yet implemented. If your application expects large data sets, additional features may be required to handle pagination effectively.

- The API assumes that all incoming data is correctly formatted and validated on the client side. Proper input validation and error handling on the client are crucial to ensure the API functions as expected.

- Authentication and authorization mechanisms are not included in this API documentation. Depending on your application's security requirements, additional layers of security may need to be implemented.

- The API documentation may not cover all edge cases or specific use cases. It's essential to thoroughly test the API in your application's context and provide appropriate error handling and feedback to users.

- This API is built with performance in mind, but specific performance tuning and optimizations may be required based on the scale and complexity of your application. Monitor API performance in production and make adjustments as needed.

- Note that this API is subject to updates and improvements. Ensure you keep the API library up-to-date and follow any release notes or migration guides provided.
Here are some example API endpoints:

- Create a new resource: `POST http://localhost:8000/api`
- Read all resources: `GET http://localhost:8000/api`


## Contact Information

For questions or support, please contact Nwinyinya David at nwinyinyadavid123@gmail.com.
