# Where do colombian flowers go?
## A visualization about colombian flowers exportation

"Colombia has more than 45 years of export experience in the flower chain. It's the first supplier for the United States and the second largest exporter of fresh flowers to the world.

With more than 1,500 varieties of flowers identified and more than 7,000 hectares cultivated, Colombia has the ideal conditions for the cultivation of a wide variety of flowers and allows the production of them throughout the year due to the fertile soil and climatic conditions."

-Procolombia


In the visualization below it's presented the colombian flowers exportation information since january 2006 to february 2018. The data was published by colombian [Ministry of Agriculture](https://www.minagricultura.gov.co/) in the open data web page for colombia www.datos.gov.co.

## Objective
To generate an interactive visualization to present and summarize relations of flowers exportation between colombian departments and countries.

## Used Technologies
* [D3](https://d3js.org/)
* [Materialize CSS](https://materializecss.com)
* PHP (To preprocess data).

## Local execution
In order to execute the visualization locally you must have a local web server installed. Fow Windows it's recommended to use [1&1](https://www.1and1.com/digitalguide/server/tools/xampp-tutorial-create-your-own-local-test-server/) tutorial, [Gestiona tu Web](https://www.gestionatuweb.net/instalar-un-servidor-web-en-linux-para-pruebas-y-aprendizaje-con-xampp/) for Linux and [MAMP](https://documentation.mamp.info/en/MAMP-Mac/First-Steps/) for macOS.

## Screenshots
![preview](/screenshot.gif)

# About the vis
## What
Dataset Type: Network.

Items(Nodes): Place (Colombian departments and Countries)

Link: Department → Country

Attributes:
1. Value (Ordered, Quantitative, Sequential)

## Why
* Summarize from which departments are exported colombian flowers to which countries. **(Summarize - Paths)(Lookup - Features)**
* Identify Colombia's most important clients. **(Identify - Outliers)**

## How
* Encode:
* * [Nodes] Separate, Order.
* Mark: Lines
* Channels:
* * [1] Color (Hue)


## Insights
* Bogotá is the most important flower exporter department in Colombia by far.
* USA is the most important colombian client in the flowers business.
* There are 4 departments that export flowers to the five continents: Bogotá, Cundinamarca, Antioquia and Valle del Cauca.

# Related Content
* [Visualization](https://cubosensei.github.io/va-assignment5-colombian-flowers-exportation/)
* [Slides](https://docs.google.com/presentation/d/18yTG5e0n797cyJNNVSEh2cNGrSqQ64SW9IPGM6fNteg/edit?usp=sharing)
* [YouTube Video](#!)


# Credits
* This content is published with 2018 MIT licence by [Manuel Alvarado](http://www.manalco.co).
* Data by colombian [Ministry of Agriculture](https://www.minagricultura.gov.co/).
