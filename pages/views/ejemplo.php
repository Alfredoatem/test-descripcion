<?php
include("../connect.php");
$tableName="jobpost";   
$targetpage = "view_data.php";  
$limit =10;
$_GET['searchtext'];


$query = "SELECT COUNT(*) as num FROM $tableName";
$total_pages = mysql_fetch_array(mysql_query($query));
$total_pages = $total_pages['num'];

$stages = 3;
$page = mysql_escape_string($_GET['page']);
if($page){
    $start = ($page - 1) * $limit; 
}else{
    $start = 0; 
    }   


// Obtener datos de pagina ///get page data
$query1 = "SELECT * FROM $tableName  WHERE jobtitle LIKE     
'%$searchtext%' LIMIT $start, $limit";
$result = mysql_query($query1);

// Initial page num setup//Configuracion del numero de pagina inicial
if ($page == 0){$page = 1;}
$prev = $page - 1;  
$next = $page + 1;  
$lastpage = ceil($total_pages/$limit);  
$LastPagem1 = $lastpage - 1;    
$paginate = '';
if($lastpage > 1)
{       
    $paginate .= "<div class='paginate'>";
    
    // Previous//anterior

    if ($page > 1){
        $paginate.= "<a href='$targetpage?page=$prev'>Previous</a>";
    }else{
        $paginate.= "<span class='disabled'>Previous</span>";   }
    // Pages   //paginas 
    if ($lastpage < 7 + ($stages * 2))  // Not enough pages to breaking it up//no hay suficinetes paginas para dividirlo
    {   
        for ($counter = 1; $counter <= $lastpage; $counter++)
        {
            if ($counter == $page){
                $paginate.= "<span class='current'>$counter</span>";
            }else{
                $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}    
        }
    }
    elseif($lastpage > 5 + ($stages * 2))   // Enough pages to hide a few?//suficientes paginas para ocultar algunas
    {
        // Beginning only hide later pages//Comienzo a ocltar paginas posteriores
        if($page < 1 + ($stages * 2))   
        {
            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
            {
                if ($counter == $page){
                    $paginate.= "<span class='current'>$counter</span>";
                }else{
                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}    
            }
            $paginate.= "...";
            $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
            $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
        }
        // Middle hide some front and some back//ocultar el el mediio algo de frente y de espalda
        elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
        {
            $paginate.= "<a href='$targetpage?page=1'>1</a>";
            $paginate.= "<a href='$targetpage?page=2'>2</a>";
            $paginate.= "...";
            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
            {
                if ($counter == $page){
                    $paginate.= "<span class='current'>$counter</span>";
                }else{
                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}    
            }
            $paginate.= "...";
            $paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
            $paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
        }
        // End only hide early pages//terminar ocultar solatmente primeras paginas
        else
        {
            $paginate.= "<a href='$targetpage?page=1'>1</a>";
            $paginate.= "<a href='$targetpage?page=2'>2</a>";
            $paginate.= "...";
            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
            {
                if ($counter == $page){
                    $paginate.= "<span class='current'>$counter</span>";
                }else{
                    $paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}
            }
        }       
    }       
            // Next//siguiente
    if ($page < $counter - 1){ 
        $paginate.= "<a href='$targetpage?page=$next'>Next</a>";
    }else{
        $paginate.= "<span class='disabled'>Next</span>";
        }
    $paginate.= "</div>";   
}

if(mysqli_num_rows($result) >0){
while($row = mysqli_fetch_array($result)) 
{
/*echo "<table>";
echo "<tr > <td>Job Title:</td> <td>{$row['jobtitle']} </td>     
</tr>".
"<tr > <td>Job Description: </td> <td>        
{$row['jobdescription']}</td> </tr> ".
"<br>";
echo "</table>"; */
}
}
?>























<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Carousel Example</h2>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <div class="item active">
                <img src="la.jpg" alt="Los Angeles" style="width:100%;">
                <div class="carousel-caption">
                <h3>Los Angeles</h3>
                <p>LA is always so much fun!</p>
                </div>
            </div>

            <div class="item">
                <img src="chicago.jpg" alt="Chicago" style="width:100%;">
                <div class="carousel-caption">
                <h3>Chicago</h3>
                <p>Thank you, Chicago!</p>
                </div>
            </div>
            
            <div class="item">
                <img src="ny.jpg" alt="New York" style="width:100%;">
                <div class="carousel-caption">
                <h3>New York</h3>
                <p>We love the Big Apple!</p>
                </div>
            </div>  
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
</div>

</body>
</html>