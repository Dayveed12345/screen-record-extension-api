
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
        - path:`Path/to/the/video.webm`
        - uploaded_time:`2023-09-29 20:39:41`
        - full-date-time:`23, september 2023`
    Fetch the Transcripted Data(GET)
    **Data**:

```json
{
    "text": "Agent any, so we'll just run with the next available agent. And as I said, these two are equivalent to this one here and they are required. Attributes you always have to use them. The next required attribute is stages and this is where the whole work actually happens. So you have different stages of that pipeline and inside the stages, you",
    "language": "en",
    "segments": [
        {
            "start": 1.08,
            "end": 1.72,
            "text": "Agent any,",
            "whole_word_timestamps": [
                {
                    "word": "Agent",
                    "start": 1.08,
                    "end": 1.36,
                    "probability": 0.62782686948776,
                    "timestamp": 1.36
                },
                {
                    "word": "any,",
                    "start": 1.36,
                    "end": 1.72,
                    "probability": 0.8545435667038,
                    "timestamp": 1.72
                }
            ]
        },
        {
            "start": 2.06,
            "end": 5.28,
            "text": "so we'll just run with the next available agent.",
            "whole_word_timestamps": [
                {
                    "word": "so",
                    "start": 2.06,
                    "end": 2.16,
                    "probability": 0.98916095495224,
                    "timestamp": 2.16
                },
                {
                    "word": "we'll",
                    "start": 2.16,
                    "end": 2.34,
                    "probability": 0.97957402467728,
                    "timestamp": 2.34
                },
                {
                    "word": "just",
                    "start": 2.34,
                    "end": 2.56,
                    "probability": 0.99634039402008,
                    "timestamp": 2.56
                },
                {
                    "word": "run",
                    "start": 2.56,
                    "end": 2.96,
                    "probability": 0.99372792243958,
                    "timestamp": 2.96
                },
                {
                    "word": "with",
                    "start": 2.96,
                    "end": 3.42,
                    "probability": 0.98560243844986,
                    "timestamp": 3.42
                },
                {
                    "word": "the",
                    "start": 3.42,
                    "end": 3.68,
                    "probability": 0.94778871536255,
                    "timestamp": 3.68
                },
                {
                    "word": "next",
                    "start": 3.68,
                    "end": 4.16,
                    "probability": 0.94850009679794,
                    "timestamp": 4.16
                },
                {
                    "word": "available",
                    "start": 4.16,
                    "end": 4.66,
                    "probability": 0.99395906925201,
                    "timestamp": 4.66
                },
                {
                    "word": "agent.",
                    "start": 4.66,
                    "end": 5.28,
                    "probability": 0.89013439416885,
                    "timestamp": 5.28
                }
            ]
        },
        {
            "start": 5.86,
            "end": 6.32,
            "text": "And as I said,",
            "whole_word_timestamps": [
                {
                    "word": "And",
                    "start": 5.86,
                    "end": 5.9,
                    "probability": 0.94940453767776,
                    "timestamp": 5.9
                },
                {
                    "word": "as",
                    "start": 5.9,
                    "end": 6.06,
                    "probability": 0.94737654924393,
                    "timestamp": 6.06
                },
                {
                    "word": "I",
                    "start": 6.06,
                    "end": 6.14,
                    "probability": 0.99126702547073,
                    "timestamp": 6.14
                },
                {
                    "word": "said,",
                    "start": 6.14,
                    "end": 6.32,
                    "probability": 0.99803775548935,
                    "timestamp": 6.32
                }
            ]
        },
        {
            "start": 6.46,
            "end": 10.56,
            "text": "these two are equivalent to this one here and they are required.",
            "whole_word_timestamps": [
                {
                    "word": "these",
                    "start": 6.46,
                    "end": 6.6,
                    "probability": 0.76227980852127,
                    "timestamp": 6.6
                },
                {
                    "word": "two",
                    "start": 6.6,
                    "end": 6.86,
                    "probability": 0.98251295089722,
                    "timestamp": 6.86
                },
                {
                    "word": "are",
                    "start": 6.86,
                    "end": 7.12,
                    "probability": 0.99418407678604,
                    "timestamp": 7.12
                },
                {
                    "word": "equivalent",
                    "start": 7.12,
                    "end": 7.48,
                    "probability": 0.93239015340805,
                    "timestamp": 7.48
                },
                {
                    "word": "to",
                    "start": 7.48,
                    "end": 7.66,
                    "probability": 0.97536510229111,
                    "timestamp": 7.66
                },
                {
                    "word": "this",
                    "start": 7.92,
                    "end": 8.04,
                    "probability": 0.98836529254913,
                    "timestamp": 8.04
                },
                {
                    "word": "one",
                    "start": 8.04,
                    "end": 8.22,
                    "probability": 0.9976395368576,
                    "timestamp": 8.22
                },
                {
                    "word": "here",
                    "start": 8.22,
                    "end": 8.48,
                    "probability": 0.9854975938797,
                    "timestamp": 8.48
                },
                {
                    "word": "and",
                    "start": 8.48,
                    "end": 8.92,
                    "probability": 0.463094830513,
                    "timestamp": 8.92
                },
                {
                    "word": "they",
                    "start": 8.92,
                    "end": 9.38,
                    "probability": 0.95126503705978,
                    "timestamp": 9.38
                },
                {
                    "word": "are",
                    "start": 9.38,
                    "end": 9.56,
                    "probability": 0.90762108564377,
                    "timestamp": 9.56
                },
                {
                    "word": "required.",
                    "start": 9.66,
                    "end": 10.56,
                    "probability": 0.90578705072403,
                    "timestamp": 10.56
                }
            ]
        },
        {
            "start": 11.26,
            "end": 12.9,
            "text": "Attributes you always have to use them.",
            "whole_word_timestamps": [
                {
                    "word": "Attributes",
                    "start": 11.26,
                    "end": 11.8,
                    "probability": 0.95338815450668,
                    "timestamp": 11.8
                },
                {
                    "word": "you",
                    "start": 11.8,
                    "end": 11.98,
                    "probability": 0.49878376722336,
                    "timestamp": 11.98
                },
                {
                    "word": "always",
                    "start": 11.98,
                    "end": 12.26,
                    "probability": 0.99229794740677,
                    "timestamp": 12.26
                },
                {
                    "word": "have",
                    "start": 12.26,
                    "end": 12.44,
                    "probability": 0.99888128042221,
                    "timestamp": 12.44
                },
                {
                    "word": "to",
                    "start": 12.44,
                    "end": 12.58,
                    "probability": 0.99934607744217,
                    "timestamp": 12.58
                },
                {
                    "word": "use",
                    "start": 12.58,
                    "end": 12.76,
                    "probability": 0.99882179498672,
                    "timestamp": 12.76
                },
                {
                    "word": "them.",
                    "start": 12.76,
                    "end": 12.9,
                    "probability": 0.9978865981102,
                    "timestamp": 12.9
                }
            ]
        },
        {
            "start": 13.54,
            "end": 19.02,
            "text": "The next required attribute is stages and this is where the whole work actually happens.",
            "whole_word_timestamps": [
                {
                    "word": "The",
                    "start": 13.54,
                    "end": 13.7,
                    "probability": 0.98166185617447,
                    "timestamp": 13.7
                },
                {
                    "word": "next",
                    "start": 13.7,
                    "end": 13.9,
                    "probability": 0.99690324068069,
                    "timestamp": 13.9
                },
                {
                    "word": "required",
                    "start": 14.1,
                    "end": 14.44,
                    "probability": 0.98749697208405,
                    "timestamp": 14.44
                },
                {
                    "word": "attribute",
                    "start": 14.44,
                    "end": 14.94,
                    "probability": 0.99049180746078,
                    "timestamp": 14.94
                },
                {
                    "word": "is",
                    "start": 14.94,
                    "end": 15.18,
                    "probability": 0.99292480945587,
                    "timestamp": 15.18
                },
                {
                    "word": "stages",
                    "start": 15.18,
                    "end": 15.54,
                    "probability": 0.93047118186951,
                    "timestamp": 15.54
                },
                {
                    "word": "and",
                    "start": 15.54,
                    "end": 16.56,
                    "probability": 0.35917037725449,
                    "timestamp": 16.56
                },
                {
                    "word": "this",
                    "start": 16.56,
                    "end": 16.74,
                    "probability": 0.99765437841415,
                    "timestamp": 16.74
                },
                {
                    "word": "is",
                    "start": 16.74,
                    "end": 16.9,
                    "probability": 0.99781215190887,
                    "timestamp": 16.9
                },
                {
                    "word": "where",
                    "start": 16.9,
                    "end": 17.12,
                    "probability": 0.99770963191986,
                    "timestamp": 17.12
                },
                {
                    "word": "the",
                    "start": 17.12,
                    "end": 17.34,
                    "probability": 0.9984079003334,
                    "timestamp": 17.34
                },
                {
                    "word": "whole",
                    "start": 17.34,
                    "end": 17.54,
                    "probability": 0.85782295465469,
                    "timestamp": 17.54
                },
                {
                    "word": "work",
                    "start": 17.54,
                    "end": 17.86,
                    "probability": 0.99226599931717,
                    "timestamp": 17.86
                },
                {
                    "word": "actually",
                    "start": 17.86,
                    "end": 18.48,
                    "probability": 0.99344080638885,
                    "timestamp": 18.48
                },
                {
                    "word": "happens.",
                    "start": 18.48,
                    "end": 19.02,
                    "probability": 0.96414941549301,
                    "timestamp": 19.02
                }
            ]
        }
    ]
}

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
- Get transcription resources: `Get https://screen-record-api.onrender.com/api1`


## Contact Information

For questions or support, please contact Nwinyinya David at nwinyinyadavid123@gmail.com.
