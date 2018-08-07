This is the API Documentation for CLASSIFIED.

**Get all ads**
----
  Returns all ads as JSON data.

* **URL**

  /

* **Method:**

  `GET`

* **URL Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
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

* **Sample Call:**

  ```javascript
    const url = `/`
    
    fetch(url)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.error(error))
  ```

**Get single ad**
----
  Returns JSON data for a single ad.

* **URL**

  /item.php?url=$:id

* **Method:**

  `GET`

*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** 
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

* **Sample Call:**

  ```javascript
    const url = `/item.php?url=$:id`
    
    fetch(url)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.error(error))
  ```
