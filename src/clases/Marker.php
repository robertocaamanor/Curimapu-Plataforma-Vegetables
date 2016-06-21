<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/5/2016
 * Time: 09:26
 */
include('src/functions/dbfunctions.php');

class Marker
{
    private $fecha;
    private $agricultor;
    private $lat;
    private $lng;
    private $id;
    private $idagricultor;
    private $comuna;
    private $nombre;
    private $especie;
    private $fechainicial;
    private $fechafinal;
    private $buscaragricultor;
    private $buscarformulario;
    private $vendedornombre;
    private $vendedorapellido;

    /**
     * Marker constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return array
     */
    public static function listMarkers()
    {
        $markerList = array();
        try {
            $sql = ("select f.fecha as Fecha,
                    f.formularioId as Id,
                    a.agricultorNom as Agricultor,
                    f.agricultorId as IdAgricultor,
                    f.location as location,
                    u.UserNameSpace as Vendedor
                    from formulario f
                    left join agricultor as a on f.agricultorId = a.agricultorId
                    left join [gam].[User] as u on u.UserName = a.UserId");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['location']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setAgricultor($row['Agricultor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function searchMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        try {
            $sql = ("select f.fecha as Fecha,
                    f.formularioId as Id,
                    a.agricultorNom as Agricultor,
                    a.agricultorUbicacion as Comuna,
                    f.agricultorId as IdAgricultor,
                    f.location as location,
                    e.especieNom as Especie,
                    u.UserFirstName as PrimerNombre,
                    u.UserLastName as SegundoNombre
                    from formulario f
                    left join agricultor as a on f.agricultorId = a.agricultorId
                    left join [gam].[User] as u on u.UserName = a.UserId
                    left join especie as e on e.especieId = f.especieId
                    where f.formularioId = '$id'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['location']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setIdAgricultor($row['IdAgricultor']);
                $marker->setAgricultor($row['Agricultor']);
                $marker->setEspecie($row['Especie']);
                $marker->setComuna($row['Comuna']);
                $marker->setVendedornombre($row['PrimerNombre']);
                $marker->setVendedorapellido($row['SegundoNombre']);
                $marker->setNombre($row['Vendedor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function agroMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        try {
            $sql = ("select f.fecha as Fecha,
                    f.formularioId as Id,
                    a.agricultorNom as Agricultor,
                    f.agricultorId as IdAgricultor,
                    f.location as location,
                    a.agricultorUbicacion as Comuna,
                    u.UserNameSpace as Vendedor
                    from formulario f
                    left join agricultor as a on f.agricultorId = a.agricultorId
                    left join [gam].[User] as u on u.UserName = a.UserId
                    where a.agricultorId = '$id'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['location']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setIdAgricultor($row['IdAgricultor']);
                $marker->setAgricultor($row['Agricultor']);
                $marker->setComuna($row['Comuna']);
                $marker->setNombre($row['Vendedor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function fechaMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        $inicio = $_POST['inicio'];
        $final = $_POST['final'];
        $nombrevendedor = $_POST['busquedavendedor'];
        try {
            $sql = ("select f.fecha as Fecha,
                    f.formularioId as Id,
                    a.agricultorNom as Agricultor,
                    f.agricultorId as IdAgricultor,
                    f.location as location,
                    a.agricultorUbicacion as Comuna,
                    u.UserNameSpace as Vendedor
                    from formulario f
                    left join agricultor as a on f.agricultorId = a.agricultorId
                    left join [gam].[User] as u on u.UserName = a.UserId
                    where f.fecha BETWEEN '".$inicio."' AND '".$final."' AND u.UserNameSpace LIKE '%".$nombrevendedor."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $fechainicial = date_format(new DateTime($inicio), "Y-m-d");
                $fechafinal = date_format(new DateTime($final), "Y-m-d");
                $locations = explode(',', $row['location']);
                $marker->setFecha($date);
                $marker->setFechainicial($fechainicial);
                $marker->setFechafinal($fechafinal);
                $marker->setId($row['Id']);
                $marker->setComuna($row['Comuna']);
                $marker->setIdAgricultor($row['IdAgricultor']);
                $marker->setAgricultor($row['Agricultor']);
                $marker->setNombre($row['Vendedor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function agricultorMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        $inicio = $_POST['inicio'];
        $final = $_POST['final'];
        $nombreagricultor = $_POST['buscaragricultor'];
        try {
            $sql = ("select f.fecha as Fecha,
                    f.formularioId as Id,
                    a.agricultorNom as Agricultor,
                    f.agricultorId as IdAgricultor,
                    f.location as location,
                    a.agricultorUbicacion as Comuna,
                    u.UserNameSpace as Vendedor
                    from formulario f
                    left join agricultor as a on f.agricultorId = a.agricultorId
                    left join [gam].[User] as u on u.UserName = a.UserId
                    where f.fecha BETWEEN '".$inicio."' AND '".$final."' AND a.agricultorNom LIKE '%".$nombreagricultor."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['location']);
                $marker->setFecha($date);
                $marker->setComuna($row['Comuna']);
                $marker->setId($row['Id']);
                $marker->setIdAgricultor($row['IdAgricultor']);
                $marker->setAgricultor($row['Agricultor']);
                $marker->setNombre($row['Vendedor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdagricultor()
    {
        return $this->idagricultor;
    }

    public function setIdagricultor($idagricultor)
    {
        $this->idagricultor = $idagricultor;
    }


    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param mixed $fecha
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    public function getComuna()
    {
        return $this->comuna;
    }

    /**
     * @param mixed $fecha
     */
    public function setComuna($comuna)
    {
        $this->comuna = $comuna;
    }

    public function getFechainicial()
    {
        return $this->fechainicial;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechainicial($fechainicial)
    {
        $this->fechainicial = $fechainicial;
    }

    public function getFechafinal()
    {
        return $this->fechafinal;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechafinal($fechafinal)
    {
        $this->fechafinal = $fechafinal;
    }

    /**
     * @return mixed
     */
    public function getAgricultor()
    {
        return $this->agricultor;
    }

    public function setAgricultor($agricultor)
    {
        $this->agricultor = $agricultor;
    }

    public function getVendedornombre()
    {
        return $this->vendedornombre;
    }

    public function setVendedornombre($vendedornombre)
    {
        $this->vendedornombre = $vendedornombre;
    }

    public function getVendedorapellido()
    {
        return $this->vendedorapellido;
    }

    public function setVendedorapellido($vendedorapellido)
    {
        $this->vendedorapellido = $vendedorapellido;
    }

    public function getbuscarAgricultor()
    {
        return $this->buscaragricultor;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarAgricultor($buscaragricultor)
    {
        $this->buscaragricultor = $buscaragricultor;
    }

    public function getbuscarFormulario()
    {
        return $this->buscarformulario;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarFormulario($buscarformulario)
    {
        $this->buscarformulario = $buscarformulario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $vendedor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }


}