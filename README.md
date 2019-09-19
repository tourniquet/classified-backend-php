# This is the API Documentation for CLASSIFIED

## Table of contents

- [Build styles](#build-styles)
- [GET /index.php?page=:page](#get-all-items)
- [GET /item.php?url=:id](#get-single-item)
- [POST /registration.php](#user-registration)
- [POST /item-posted.php](#item-posted)
- [POST /search.php](#search)

## **Build styles**

---

- In root folder, run **sass styles/import.scss styles/styles.css**
- For --watch mode, in root folder, run **sass --watch styles/import.scss styles/styles.css**

## **Get all items**

---
  Returns all ads as JSON data.

- **URL**

  /index.php?page=1

- **Method:**

  `GET`

- **URL Params**

  **Optional:**

  `page=[integer]`

- **Success Response:**

  - **Code:** 200
  - **Content:**
    ```json
      items: [{
        "id": "130",
        "url": "24409687",
        "user_id": null,
        "user_email": "",
        "published": "2019-09-18 17:33:29",
        "modified": null,
        "title": "Test title",
        "description": "Test category",
        "phone": "7447459323",
        "visitor_name": "John Doe",
        "price": "",
        "enabled": "1",
        "views": "1",
        "currency_id": "1",
        "region_id": "1",
        "subcategory_id": "2",
        "subcategory": "Cars",
        "category": "Transport",
        "images": "24409687_0.jpg"
      }],
      page: "1",
      total: "118"
    ```

- **Sample Call:**

  ```javascript
    const url = `/index.php?page=1`

    fetch(url)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.error(error))
  ```

## **Get single item**

---
  Returns JSON data for a single ad.

- **URL**

  /item.php?url=:url

- **Method:**

  `GET`

- **URL Params**

   **Required:**

   `url=[integer]`

- **Data Params**

  None

- **Success Response:**

  - **Code:** 200
  - **Content:**
    ```json
      {
        "id": "130",
        "url": "24409687",
        "user_id": null,
        "user_email": "",
        "published": "2019-09-18 17:33:29",
        "modified": null,
        "title": "Test title",
        "description": "Test description",
        "phone": "7447459323",
        "visitor_name": "John Doe",
        "price": "",
        "enabled": "1",
        "views": "1",
        "currency_id": "1",
        "region_id": "1",
        "subcategory_id": "2",
        "subcategory": "Cars",
        "category": "Transport",
        "currency": "",
        "region": "London",
        "images": [
          "24409687_0.jpg"
        ]
      }
    ```

- **Sample Call:**

  ```javascript
    const url = `/item.php?url=24409687`

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
Send JSON data to create a new ad

- **URL**
  /item-posted.php

- **Method:**
  `POST`

- **URL Params**
    None

- **Data params**
  ```json
    {
      "title": "string",
      "description": "string",
      "images[]": "array",
      "phone": "number",
      "name": "string",
      "email": "string",
      "price": "string?",
      "url": "number",
      "userId": "number",
      "userEmail": "string"
    }
  ```
- **Success Response:**

    **Content:**
    ```json
      {
        "url": 12345678
      }
    ```

- **Sample Call:**

  ```javascript
    const url = `${apiHost}/item-posted.php`
    window
      .fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(result => props.history.push(`/item/${result.url}`))
      .catch(err => console.error(err))
  ```

## **Search**
---
Send JSON data to create a search query

- **URL**

  /search.php

- **Method:**

  `POST`

- **URL Params**

  None

- **Data Params**

  ```json
    {
      "body": "keywords"
    }
  ```

- **Success Response:**

    **Content:**
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
    const searchQuery = 'keywords'

    const url = `/search.php`
    fetch(url, {
      method: 'POST',
      body: JSON.stringify(searchQuery)
    })
      .then(() => ())
      .catch(error => console.error(error))
  ```
