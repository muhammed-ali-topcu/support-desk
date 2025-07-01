# Support Desk

# installation

1. clone the repository
    `git clone git@github.com:muhammed-ali-topcu/support-desk.git`
2. go to the project directory
    `cd support-desk`
3. run `composer install`
4. run `npm install`
5. run `npm run build`
6. copy `.env.example` to `.env`
7. run `php artisan key:generate`
8. run `php artisan migrate`
9. run `php artisan db:seed`
10. run `composer dev`
11. in new terminal run `php artisan schedule:work`


# usage

1. create new support request  by api
    `POST /api/support-requests`
    ```json
    {
        "email": "ali@example.com",
        "subject": "Support Request",
        "message": "Support Request Message"
    }
    ```

2. add new support request by email
 send email to `m.developer.062025@gmail.com` with subject and message

3. login to dashboard 'http://localhost:8000/login'
    `email: m.developer.062025@gmail.com`
    `password: password`

4. list support requests
    'http://localhost:8000/support-requests'

5. you can also see the actual inbox of `m.developer.062025@gmail.com` in 'http://localhost:8000/gmail'

    
    






