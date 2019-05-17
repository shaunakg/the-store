# The Store
### This is a fully functional store with webmail and a catalog, plus a cart

## How to operate
1. Import the store_database.sql backup into your SQL database (I use mySQL with phpMyAdmin, your experience may vary)
2. Just use it like a normal website (I use xampp)

## Important notes
- Anybody can become an admin, that feature is not currently restricted. If you want, you could set some kind of preauth to be needed to become an admin
- There IS an API, under store/login/api (this is because I actually started developing the login page before the store). It does not have any features apart from user creation and deletion
- There are a HUGE number of security flaws. Example: forgot my password doesn't require auth (I will put this in issues, probably under #1)

## Auth pages
- Under auth/
- all_transactions.php (Lets you view all transaction by all users)
- all_webmail.php (Lets you view all the webmail sent) **If you want to send mail to all users, use the all_users address**
- new_item.php (Lets you create a new item in the store)
- topup.php (Lets you topup or debit balances)

## License
Do what you want, except:
- You must credit me
- You must not patent it in any way
- No part of it may be trademarked
- Additionally, the terms of the license (specified)[LICENSE] apply.
