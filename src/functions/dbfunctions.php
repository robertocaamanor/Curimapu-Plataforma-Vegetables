<?php

function connectDB()
{
    $conn=mssql_connect("xcom.ddns.net", "sa", "jYcC5DLt");
    mssql_select_db("CURIMAPUVEGETALESDEVICESSSSS", $conn);
    return $conn;
}

function query($conn , $query)
{
    $result = mssql_query($query, $conn);
    return $result;
}

function countRows($query)
{
    $q = mssql_num_rows($query);
    return $q;
}

function parse($query)
{
    $result = mssql_fetch_array($query);
    return $result;
}

function cerrar($conn)
{
    mssql_close($conn);  
}

function listarVegetales($conn, $inicial, $final)
{
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId
    where f.fecha BETWEEN '".$inicial."' AND '".$final."'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarAgricultores($conn)
{
    $sql = "select agricultorId as id, agricultorNom as Nombre
            from agricultor";
    $result = query($conn, $sql);
    return $result;
}

function buscarAgricultor($conn, $nombre)
{
    $sql = "select agricultorId as id, agricultorNom as Nombre
            from agricultor
            where agricultorNom LIKE '%".$nombre."%'";
    $result = query($conn, $sql);
    return $result;
}



function detalleVegetales($id, $conn){
    $sql = "SELECT a.agricultorNom as Agricultor, f.fecha as Fecha, e.especieNom as especie, a.agricultorUbicacion as Ubicacion, a.agricultorEmail as email, a.agricultorFono as telefono, f.estaFenologico as estadofenologico, f.estaCrecimiento as estadocrecimiento, f.estaMalezas as malezas, f.estaFitosanitario as fitosanitario, f.poblacion as poblacion, f.cosecha as cosecha, f.malePrincipales as malezasprincipales, f.honBacVir as hongosbacterias, f.insectos as insectos, f.estadoGene as estadogeneral, f.formularioVariedad as nombreVariedad, f.Observaciones as observaciones, f.Recomendacioness as recomendaciones, f.imagen_GXI as imagen, f.formularioId as lote
                from formulario as f inner join agricultor as a on f.agricultorId = a.agricultorId inner join especie as e on e.especieId = f.especieId
                WHERE f.formularioId =".$id;
    $result = query($conn, $sql);
    return $result;

}

function detalleAgricultores($id, $conn){
    $sql = "select a.agricultorNom as nombre,
            a.agricultorUbicacion as ubicacion,
            a.agricultorFono as telefono,
            a.agricultorEmail as email,
            a.agricultorRut as rut,
            a.UserID as Vendedor
            from agricultor a inner join [gam].[User] as u on a.UserID = u.UserName
            where a.agricultorId =".$id;
    $result = query($conn, $sql);
    return $result;

}

function listarvegetalesfecha($conn, $inicial, $final){
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId
            where f.fecha between '".$inicial."' and '".$final."'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}

//SELECT f.formularioNom as nombreformulario, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion from formulario as f inner join agricultor as a on f.agricultorId = a.agricultorId
            //where f.formularioNom LIKE '%".$nombre."%

function listarvegetalesvendedor($conn, $nombre){
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId where u.UserNameSpace LIKE '%".$nombre."%'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvegetalesagricultor($conn, $nombre){
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId
            where a.agricultorNom LIKE '%".$nombre."%'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvegetalesmixto($conn, $nombre, $inicial, $final){
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId
    where f.fecha BETWEEN '".$inicial."' AND '".$final."' AND a.UserID LIKE '%".$nombre."%'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvegetalesagricultormixto($conn, $nombre, $inicial, $final){
    $sql = "SELECT u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, f.formularioId as id, f.fecha as fecha, a.agricultorNom as agricultor, f.Observaciones as observacion, a.agricultorUbicacion as Ubicacion, e.especieNom as Especie FROM Formulario f left join Agricultor as a on f.agricultorId = a.agricultorId left join [gam].[User] as u on u.UserName = a.UserId left join especie as e on e.especieId = f.especieId
    where f.fecha BETWEEN '".$inicial."' AND '".$final."' AND a.agricultorNom LIKE '%".$nombre."%'
            order by f.fecha desc";
    $result = query($conn, $sql);
    return $result;
}