# Complaint Registration Portal
A complaint registration website built using html/css/js and MySql. 

## Installation on localhost using XAMPP
Download the source code, or use the below git command:
```bash
git clone https://github.com/nilz-bilz/complaint-register-wtproject.git
```

Move the file to the `htdocs` folder, that serves the website on localhost. 
Usually present in `C:\xampp\htdocs`

After starting the Apache & MySQL service in XAMPP, navigate to `localhost/phpmyadmin`

Click on the "SQL" tab and paste the contents of the [database.sql](https://raw.githubusercontent.com/nilz-bilz/complaint-register-wtproject/refs/heads/main/database.sql) file.
![image](https://github.com/user-attachments/assets/63f3370f-f6f3-4d18-a062-9836bd7e3121)

Once you're done, you will see the schema by clicking on the new DB towards the left pane
![image](https://github.com/user-attachments/assets/1a946be4-11b2-4e1c-a799-63ea7c3ce825)

### Usage
Navigate to `localhost/complaint-register-wtproject`
![image](https://github.com/user-attachments/assets/eda25f10-a85b-43dc-9c81-5536a53ee59f)

------

## Deploying with docker compose
Download the source code, or use the below git command:
```bash
git clone https://github.com/nilz-bilz/complaint-register-wtproject.git
```

edit the `docker-compose.yaml` file and deploy:
```bash
sudo docker compose up -d
```

Access phpMyAdmin and run the `database.sql` file. 
Transfer files to the destination mapped to the container.

Adjust ports or reverse proxy labels as per your needs