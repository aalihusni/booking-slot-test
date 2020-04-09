## Checkout the master branch of this repository. 

- either use valet or docker you could load this source
- setup your own database connection inside `.env` file, i'm using standard `.env`
- run `php artisan migrate`
- run `npm install`
- either use virtualization or `npm run serve`

# What this code will do? 
- You can add new booking, no session or user the api is exposed to easy building the data
- After you add new booking you will see the slot you book, but there's no distinction for each user
- It wont handle your daily business, it's a POC of these requirements:

# Operation Rules:
- This code will have 2 inspection slot every 30mins, from 9AM to 6PM on weekdays
- This code will have 4 inspection slot every 30mins, from 9AM to 6PM on Saturday
- This code will rest on Sunday
- You can only book for the date of next 3 weeks
