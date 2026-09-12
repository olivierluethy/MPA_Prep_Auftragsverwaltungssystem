<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem">
    <img src="images/verwaltung.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Mini PA Preperation</h3>

  <p align="center">
    Here I'll explain about what this project is and how you set it up!
    <br />
    <a href="https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem/blob/master/README.md"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem">View Demo</a>
    ·
    <a href="https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem/issues">Report Bug</a>
    ·
    <a href="https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem/issues">Request Feature</a>
  </p>
</p>

<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li>
      <a href="#installation-guide">Installation Guide</a>
    </li>
    <li>
      <a href="#problems-during-project">Problems during project</a>
    </li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project

After the nice summer holidays I went back to my work. When I arrived there, they were saying that in two weeks I will have a mini pa (it's like a big project) and they told me about what it is. Later on I decided to create a little project that will prepare me for the mini pa. 

The project is actually very simple. In there you can see all employees and tasks which have been added to the database. You can add stuff to it, delete or edit it.

<!-- INSTALLATION -->
## Installation Guide

### 🐳 Quick start with Docker (recommended)

The whole stack (PHP app + MySQL + phpMyAdmin + lots of mock data) runs with one command:

```sh
docker compose up -d --build
```

- App: <http://localhost:8100> — login `admin@minipa.test` / `admin`
- Database UI (phpMyAdmin): <http://localhost:8101> — login `root` / `root`

Full details, mock-data info and troubleshooting are in **[DOCKER.md](DOCKER.md)**.

### Manual install (XAMPP)

1. At first you need to install git on your local computer. For that you need to go to this [website](https://git-scm.com/downloads).
2. Go to your windows explorer and search for a good place for storing this project
3. Now right click on your folder or place and then click on "Git Bash Here"
4. Finally you will see a new program. If you do you only have to enter this
   ```sh
   git clone https://github.com/olivierluethy/MPA_Prep_Auftragsverwaltungssystem.git
   ```

<!-- Problems during project -->
## Problems during project

1. [How to check if current date time has passed a set date time in PHP](https://write.corbpie.com/php-check-if-current-date-time-has-passed-a-set-date-time/)<br>
In the end, this solution was removed from the project, and instead I tweaked something in the SQL select statement.

2. [How to document methods and functions inside of a php code](https://de.wikipedia.org/wiki/PHPDoc)

3. [Find if date is older than 30 days](https://stackoverflow.com/questions/7130738/find-if-date-is-older-than-30-days/7130744)<br>
This was used instead of solution 1.
