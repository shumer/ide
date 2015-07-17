Do I need it?
------------
At some point i was tired of creating custom pages using menu and form api,
writing tons of code just to have a page with ugly form where client can enter some settings,
and as soon as client want to add some interactions to the page (drag&drop, ajax etc) thing starts to get hairy.
If this sounds familiar then this module may be just a thing you looking for :)

Introduction
------------
This module provide fieldable entity that allows to create customisable feature-rich configuration
pages and place them where you like in menu system, you are able to use fieldAPI
with fine widgets created by community, so multi values drag&drop, autocomplete, file uploads
looks pretty and just works out of the box!

Main features are:

- Fieldable entity (config page)
Create fieldable entity using BO, FieldAPI, Features and other entity modules are supported.

- Mount your config page into menu structure as you like
Your can choose how (where) user will access this config page, so it can have proper path like
'admin/config/mysettings' and not explain customer that he needs to create "a special node" in node/add.

- Context-awareness
You need to have same page with different settings based on current language or domain or some other factor?
Config pages controller will automatically load proper config page based on current context. You can copy settings
from one context to another, import and export text values using Features. Language and Domain (Domain module)
contexts are supplied with this module, but you can add your custom context in no time using module's API.

- Create "singleton" pages
You no longer need to create a new content type that will store fields for your "singleton" pages like homepage
and explain to client that this page is a content but he can't create 2 nodes in it.

- Nodequeue replacement.
In 95% cases using config pages will give you more flexibility than nodequeue module,
if you use EntityReference field, and use views as autocomplete source, so you have all the power of
views at your hands. And it will have all the features above - context awareness, themable and more.

Installation
-------------
Install this module as any other module

Generic workflow
-------------------------------
TODO: write workflow
