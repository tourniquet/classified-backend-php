# This is the API Documentation for CLASSIFIED

## Table of contents

- [Build styles](#build-styles)
- [GET /](#get-all-ads)
- [GET /item.php?url=$:id](#get-single-ad)
- [POST /registration.php](#user-registration)
- [POST /item-posted.php](#item-posted)

## **Build styles**

---

- In root folder, run **sass styles/import.scss styles/styles.css**
- For --watch mode, in root folder, run **sass --watch styles/import.scss styles/styles.css**

## **Get all ads**

---
  Returns all ads as JSON data.

- **URL**

  /

- **Method:**

  `GET`

- **URL Params**

  None

- **Success Response:**

  - **Code:** 200
  - **Content:**
    ```json
      [
        {
          "id": "40",
          "published": "2018-08-06 20:58:57",
          "name": "John",
          "title": "Ad title",
          "description": "Ad description",
          "price": "3.20",
          "image": null,
          "enabled": "0",
          "url": "89137472",
          "views": "17"
        },
        {
          "id": "40",
          "published": "2018-08-06 20:58:57",
          "name": "John",
          "title": "Ad title",
          "description": "Ad description",
          "price": "3.20",
          "image": null,
          "enabled": "0",
          "url": "89137471",
          "views": "17"
        },
        {
          ...
        }
      ]
    ```

- **Sample Call:**

  ```javascript
    const url = `/`

    fetch(url)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.error(error))
  ```

## **Get single ad**

---
  Returns JSON data for a single ad.

- **URL**

  /item.php?url=$:id

- **Method:**

  `GET`

- **URL Params**

   **Required:**

   `id=[integer]`

- **Data Params**

  None

- **Success Response:**

  - **Code:** 200
  - **Content:**
    ```json
      {
        "id": "40",
        "published": "2018-08-06 20:58:57",
        "name": "John",
        "title": "Without title?",
        "description": "Not good! Not good!",
        "price": "320",
        "image": null,
        "enabled": "0",
        "url": "89137472",
        "views": "17"
      }
    ```

- **Sample Call:**

  ```javascript
    const url = `/item.php?url=$:id`

    fetch(url)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.error(error))
  ```

## **User registration**

---
Send JSON data to register user

- **URL**

  /registration.php

- **Method:**

  `POST`

- **URL Params**

    None

- **Data Params**

  ```json
    {
      "email": "username@example.com",
      "password": "qwerty123",
      "passwordConfirmation": "qwerty123"
    }
  ```

- **Success Response:**

    **Content:**
    ```text
      Success!
    ```

- **Sample Call:**

  ```javascript
    const data = {
      email: 'email@example.com',
      password: 'qwerty123',
      passwordConfirmation: 'qwerty123'
    }

    const url = `/registration.php`
    fetch(url, {
      method: 'POST',
      body: JSON.stringify(data)
    })
      .then(() => ())
      .catch(error => console.error(error))
  ```

## **Item posted**
---
