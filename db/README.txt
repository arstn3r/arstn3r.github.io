Team kit - your team site (the web/ folder of your team)
1. Right-click team_kit.zip -> Extract All... -> C:\webkit\team
2. Open db.php (VS Code). On line 8, change TeamN to your team name, for example Team3. Save.
   This is the only place with the database name. The example pages use bookstore.
3. Your team database must be on this PC. Not in SSMS (Databases)? Run sql/team.sql in SSMS (F5).
4. Double-click run-team.bat. The browser opens http://localhost:8001/ (the menu).
   Keep the black window open. Close it to stop the site.
5. Make a folder with your table name, for example students. Put list.php in it.
   The menu shows it by itself. Copy the style of example/list.php and example/insert.php.
Files: db.php (connection + db_query, db_fetch, sql_box) - header.php - footer.php -
       index.php (menu) - css/style.css - example/ (Book Store pages)
Problems: login failed = wrong name in db.php or no database (step 3).
          Invalid object name = the table is not in this database.
          Port 8001 is in use = close the other run-team.bat window.
Steps and prompts: course site, Week 12, Part 2.
