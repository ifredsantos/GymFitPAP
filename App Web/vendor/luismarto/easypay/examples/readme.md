## Examples that demonstrate how to use the PHP wrapper for Easypay API integration

Here you can access fully functional code on how to integrate with Easypay using 
[luismarto/easypay package](https://github.com/luismarto/easypay)

# How to use

1. Execute the `sample-database.sql` code in [schema/](schema/)
2. Rename `config-example.php` to `config.php`
3. Update the settings in `config.php` with your Easypay and DB information
4. Prepare your webserver to allow requests

# What will the source code do?
1. `mb-create-reference.php` calls Easypay to create a MB reference. It will store the information on the `orders` and `easypay_references`
 tables and will display the payment information on your browser
2. `mb-real-time-notification.php` should be called with the parameters `ep_cin`, `ep_user` and `ep_doc` (see the source code for the example
link). This file replicates the request Easypay performs for real time notifications.
        
    The point is to retrieve the full details of the payment and update `easypay_references` and create a new row on `easypay_payments`
