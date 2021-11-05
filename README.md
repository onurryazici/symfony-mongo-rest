# symfony-mongo-rest

I have created a rest api for simple CRUD app with PHP Symfony framework.

# Demo
Clone this repo
`git clone https://github.com/onurryazici/symfony-mongo-rest.git`

Edit .env file and change `MONGODB_URL` and `MONGODB_DB` variables
`
MONGODB_URL=mongodb+srv://YOUR_USER:YOUR_PASSWORD@yourmongodbatlasurl
MONGODB_DB=YOUR_DB_NAMAE
`

Start your server in project root directory:
`symfony server:start`
# API

## API Endpoints

| URL |HTTP Method  | Description |
|-----|--|--|
|`127.0.0.1:8000/user`      |` GET  `| Return user list |
|`127.0.0.1:8000/user/{id}` |` GET  `| Return only one user by id |
|`127.0.0.1:8000/user`      |` POST `| Adding a user to db (Parameters below)|
|`127.0.0.1:8000/user/{id}` |`DELETE`| Delete user by id          |
|`127.0.0.1:8000/user/{id}` |`PATCH `| Update user by id (Parameters below)|


### Show Specific User ###

Returns json data about specific user by id.

* **URL**  /user/:id
* **Method:** `GET`
*  **URL Params**
   **Required:** `id=[integer]`
* **Success Response:**
    * **Code:** 200
      **Content:**
      ```json
      {
          id: "0354684",
          username: "22",
          phone: "22",
          email: "onurryazicii@gmail.com",
          address: "22",
          createdAt: {
              date: "2020-01-25 22:31:23.647000",
              timezone_type: 3,
              timezone: "Europe/Istanbul"
          }
      }
      ```


### Show All User ###

Returns json data about specific user by id.

* **URL**  /user
* **Method:** `GET`
* **Success Response:**
    * **Code:** 200
      **Content:**
      ```json
      {
          id: "0354684",
          username: "22",
          phone: "22",
          email: "onurryazicii@gmail.com",
          address: "22",
          createdAt: {
              date: "2020-01-25 22:31:23.647000",
              timezone_type: 3,
              timezone: "Europe/Istanbul"
          }
      }
      ...
      ...
      ```

### Delete Specific User ###

Returns json data about deleting  specific user by id.

* **URL**  /user/:id
* **Method:** `DELETE`
* **URL Params**
  **Required:** `id=[integer]`
* **Success Response:**
    * **Code:** 200
      **Content:**
      ```json
      {
          statu: true,
          message: "{id} successfully deleted",
      }
      ```

* **Error Response:**
    * **Code:** 404
      **Content:**
      ```json
      {
          statu: false,
          message: "There is no such user with this id : {id}",
      }
      ```

### Update Specific User ###

Returns json data about specific user by id.

* **URL**  /user/:id
* **Method:** `PATCH`
* **URL Params**
  **Required:** <br/>`
  id=[integer]`
  `username=[string]`
  `email=[string]`
  `phone=[string]`
  `address=[string]`
* **Success Response:**
    * **Code:** 200
      **Content:**
      ```json
      {
          statu: true,
          message: "User updated",
      }
      ```

* **Error Response:**
    * **Code:** 404
      **Content:**
      ```json
      {
          statu: false,
          message: "There is no such user with this id : {id}",
      }
      ```

### Add User ###

Returns json data about specific user by id.

* **URL**  /user/
* **Method:** `POST`
* **URL Params**
  **Required:**
  `username=[string]`
  `email=[string]`
  `phone=[string]`
  `address=[string]`
* **Success Response:**
    * **Code:** 200
      **Content:**
      ```json
      {
          statu: true,
          message: "User successfully added",
      }
      ```
