# This is the API Documentation for CLASSIFIED

## Table of contents

- [Build styles](#build-styles)
- [GET /index.php?page=:page](#get-all-items)
- [GET /item.php?url=:id](#get-single-item)
- [POST /registration.php](#user-registration)
- [POST /item-posted.php](#item-posted)
- [POST /search.php](#search)
- [GET /category.php](#category)
- [GET /subcategory.php](#subcategory)
- [GET /categories.php](#categories)
- [GET /subcategories.php](#subcategories)
- [GET /regions.php](#regions)

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

- **Data params (form-data)**
  ```form-data
    title: Example title
    description: Example description
    images[]: (binary)
    phone: 555-5555
    visitor-name: "John Doe
    email: email@example.com
    price: 20
    subcategoryId: 3
    regionId: 1
    url: 25349429
    userId: 1
    userEmail: email@example.com
    currencyId: 1
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

  /search.php?page=1

- **Method:**

  `POST`

- **URL Params**

  **Required:**

  `page=[integer]`

- **Data Params**

  ```json
    {
      "body": "keywords"
    }
  ```

- **Success Response:**

    **Content:**
    ```json
    {
      "items":
      [{
        "id": "131",
        "url": "25349429",
        "user_id": null,
        "user_email": "",
        "published": "2019-09-19 21:35:49",
        "modified": null,
        "title": "Example title",
        "description": "Example description",
        "phone": "555-5555",
        "visitor_name": "John Doe",
        "price": "30",
        "enabled": "1",
        "views": "1",
        "currency_id": "1",
        "region_id": "1",
        "subcategory_id": "3"
      }],
    "page": "1",
    "total": "1"
    }
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

## **Category**
---
Returns all adds with a specific category

- **URL**

  /category.php?category=:category&page=:pageNumber

- **Method:**

  `GET`

- **URL Params**

  **Required:**

  `category=[string]`

  `pageNumber=[integer]`

- **Data Params**

  None

- **Success Response:**

    **Content:**
    ```json
    "items": [
      {
        "id": "115",
        "url": "61650910",
        "user_id": "1",
        "user_email": "email@example.com",
        "published": "2019-08-22 09:14:11",
        "modified": null,
        "title": "Example title",
        "description": "Example description",
        "phone": "7448459333",
        "visitor_name": "John Doe",
        "price": "",
        "enabled": "1",
        "views": "0",
        "currency_id": "1",
        "region_id": "1",
        "subcategory_id": "3",
        "subcategory": "Trucks",
        "category": "Transport"
      }
    ],
    "page": "1",
    "total": "118"
    ```

- **Sample Call:**

  ```javascript
    const url = `/category.php?category=${category}&page=1`

    window
      .fetch(url)
      .then(response => response.json())
      .then(result => ())
      .catch(err => console.error(err))
  ```

## **Subcategory**
---
Returns all adds with a specific subcategory

- **URL**

  /subcategory.php?subcategory=:subcategory&page=pageNumber

- **Method:**

  `GET`

- **URL Params**

  **Required:**

  `subcategory=[string]`

  `pageNumber=[integer]`

- **Data Params**

  None

- **Success Response:**

    **Content:**
    ```json
       "items": [{
          "id": "124",
          "url": "62485226",
          "user_id": "1",
          "user_email": "admyn3d@gmail.com",
          "published": "2019-09-04 21:17:19",
          "modified": null,
          "title": "Some people say",
          "description": "Some people say",
          "phone": "7448459321",
          "visitor_name": "Ion Prodan",
          "price": "",
          "enabled": "0",
          "views": "4",
          "currency_id": "1",
          "region_id": "1",
          "subcategory_id": "3",
          "subcategory": "Trucks",
          "category": "Transport",
          "images": "62485226_2.gif"
      }],
      "page": "1",
      "total": "14"
    ```

- **Sample Call:**

  ```javascript
    const url = `/subcategory.php?subcategory=Trucks&page=1`

    window
      .fetch(url)
      .then(response => response.json())
      .then(result => ())
      .catch(err => console.error(err))
  ```

## **Categories**
---
Returns all available categories as list

- **URL**

  /categories.php

- **Method:**

  `GET`

- **URL Params**

   None

- **Data Params**

  None

- **Success Response:**

    **Content:**
    ```json
      [
        {
          "id": "1",
          "title": "Property",
          "parent_id": null
        },
        {
          "id": "3",
          "title": "Motors",
          "parent_id": null
        }
      ]
    ```

- **Sample Call:**

  ```javascript
    const url = `/categories.php`

    window
      .fetch(url)
      .then(response => response.json())
      .then(result => ())
      .catch(err => console.error(err))
  ```

## **Subcategories**
---
Returns all subcategories with a specific parent category id as list

- **URL**

  /subcategories.php?parent_id=:id

- **Method:**

  `GET`

- **URL Params**

   **Required:**

   `id=[integer]`

- **Data Params**

  None

- **Success Response:**

    **Content:**
    ```json
      [
        {
            "id": "2",
            "name": "Cars",
            "parent_id": "1"
        },
        {
            "id": "3",
            "name": "Trucks",
            "parent_id": "1"
        }
      ]
    ```

- **Sample Call:**

  ```javascript
    const url = `/subcategories.php?id=1`

    window
      .fetch(url)
      .then(response => response.json())
      .then(result => ())
      .catch(err => console.error(err))
  ```

## **Regions**
---
Returns all regions as list

- **URL**

  /regions.php

- **Method:**

  `GET`

- **URL Params**

  None

- **Data Params**

  None

- **Success Response:**

    **Content:**
    ```json
      [
        {
          "id": "1",
          "name": "London"
        },
        {
          "id": "2",
          "name": "Manchester"
        }
      ]
    ```

- **Sample Call:**

  ```javascript
    const url = `/regions.php`

    window
      .fetch(url)
      .then(response => response.json())
      .then(result => ())
      .catch(err => console.error(err))
  ```
