<?php

require_once 'fpdf.php';

class ReporterV1 extends FPDF
{
    protected $ProcessingTable = false;
    protected $aCols = array();
    protected $TableX;
    protected $HeaderColor;
    protected $HeaderFontColor; // By AFB 26102020
    protected $RowColors;
    protected $RowFontColor; // By AFB 26102020
    protected $ColorIndex;

    public function Title($title)
    {
        //$this->Image('logo-sf.png', 10, 10, 45);
        //$this->SetFont('Arial', '', 20);
        //$this->Cell(0 , 6, $title, 0, 1,'C');
        //$this->Ln(9);
        //$this->Header();
        $this->Image('logo-sf.png', 10, 10, 45);
        $this->SetFont('Arial', '', 20);
        $this->SetTextColor(52, 58, 64);
        $this->Cell(0 , 6, utf8_decode($title), 0, 1, 'C');
        $this->Ln(9);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Reporte generado el ' . date('d/m/Y H:i:s')), 0, 0, 'L');

        $this->AliasNbPages();
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . ' de {nb}'), 0, 0, 'C');

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Desarrollado por Starfleet Company, Inc.'), 0, 0, 'R');
    }

    public function Header()
    {    
        // Print the table header if necessary
        if($this->ProcessingTable)
        {
            $this->TableHeader();
        }
    }

    public function TableHeader()
    {
        $this->SetFont('Arial','B',12);

        $fill = !empty($this->HeaderFontColor); //By AFB 26102020
        if($fill) //By AFB 26102020
            $this->SetTextColor($this->HeaderFontColor[0],$this->HeaderFontColor[1],$this->HeaderFontColor[2]); //By AFB 26102020

        $this->SetX($this->TableX);
        $fill=!empty($this->HeaderColor);
        if($fill)
            $this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
        foreach($this->aCols as $col)
            $this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
        $this->Ln();
    }

    public function Row($data)
    {
        $this->SetX($this->TableX);

        $fill = !empty($this->RowFontColor); // By AFB 26102020
        if($fill) // By AFB 26102020
            $this->SetTextColor($this->RowFontColor[0],$this->RowFontColor[1],$this->RowFontColor[2]); // By AFB 26102020

        $ci=$this->ColorIndex;
        $fill=!empty($this->RowColors[$ci]);
        if($fill)
            $this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
        foreach($this->aCols as $col)
            $this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
        $this->Ln();
        $this->ColorIndex=1-$ci;
    }

    public function CalcWidths($width, $align)
    {
        // Compute the widths of the columns
        $TableWidth=0;
        foreach($this->aCols as $i=>$col)
        {
            $w=$col['w'];
            if($w==-1)
                $w=$width/count($this->aCols);
            elseif(substr($w,-1)=='%')
                $w=$w/100*$width;
            $this->aCols[$i]['w']=$w;
            $TableWidth+=$w;
        }
        // Compute the abscissa of the table
        if($align=='C')
            $this->TableX=max(($this->w-$TableWidth)/2,0);
        elseif($align=='R')
            $this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
        else
            $this->TableX=$this->lMargin;
    }

    public function AddCol($field=-1, $width=-1, $caption='', $align='L')
    {
        // Add a column to the table
        if($field==-1)
            $field=count($this->aCols);
        $this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
    }

    public function Table($link, $query, $prop=array())
    {
        // Execute query
        $res=mysqli_query($link,$query) or die('Error: '.mysqli_error($link)."<br>Query: $query");
        // Add all columns if none was specified
        if(count($this->aCols)==0)
        {
            $nb=mysqli_num_fields($res);
            for($i=0;$i<$nb;$i++)
                $this->AddCol();
        }
        // Retrieve column names when not specified
        foreach($this->aCols as $i=>$col)
        {
            if($col['c']=='')
            {
                if(is_string($col['f']))
                    $this->aCols[$i]['c']=ucfirst($col['f']);
                else
                    $this->aCols[$i]['c']=ucfirst(mysqli_fetch_field_direct($res,$col['f'])->name);
            }
        }
        // Handle properties
        if(!isset($prop['width']))
            $prop['width']=0;
        if($prop['width']==0)
            $prop['width']=$this->w-$this->lMargin-$this->rMargin;
        if(!isset($prop['align']))
            $prop['align']='C';
        if(!isset($prop['padding']))
            $prop['padding']=$this->cMargin;
        $cMargin=$this->cMargin;
        $this->cMargin=$prop['padding'];
        if(!isset($prop['HeaderColor']))
            $prop['HeaderColor']=array();
        $this->HeaderColor=$prop['HeaderColor'];

        if(!isset($prop['HeaderFontColor'])) // By AFB 26102020
            $prop['HeaderFontColor']=array(); // By AFB 26102020
        $this->HeaderFontColor=$prop['HeaderFontColor']; // By AFB 26102020

        if(!isset($prop['color1']))
            $prop['color1']=array();
        if(!isset($prop['color2']))
            $prop['color2']=array();
        $this->RowColors=array($prop['color1'],$prop['color2']);

        if(!isset($prop['RowFontColor'])) // By AFB 26102020
            $prop['RowFontColor']=array(); // By AFB 26102020
        $this->RowFontColor=$prop['RowFontColor']; // By AFB 26102020
        // Compute column widths
        $this->CalcWidths($prop['width'],$prop['align']);
        // Print header
        $this->TableHeader();
        // Print rows
        $this->SetFont('Arial', '', 11);
        $this->ColorIndex=0;
        $this->ProcessingTable=true;
        while($row=mysqli_fetch_array($res))
            $this->Row($row);
        $this->ProcessingTable=false;
        $this->cMargin=$cMargin;
        $this->aCols=array();
    }

    public function CSV($link, $query, $file)
    {
        //mysqli_set_charset($link, "utf8");
        $result  = mysqli_query($link,$query);
        //$headers = mysqli_query($link,$query);

        $fields  = mysqli_num_fields($result);
        $headers = array();

        for($i = 0; $i < $fields; $i++)
        {
            $headers[] = mysqli_fetch_field_direct($result, $i)->name;
        }

        $fp = fopen('php://output', 'w'); // Generamos un FILE STREAM en memoria, que luego será descargado como archivo CSV

        //if($fp && $result && $headers) // Validamos que las consultas y el file stream existan
        if($fp && $result)
        {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $file . '.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
    
            //fputcsv($fp, array_keys($headers->fetch_assoc()), ';'); // Con array_keys, generamos dinámicamente las cabeceras del CSV
            fputcsv($fp, $headers, ';');
    
            while($row = $result->fetch_array())
            {
                for($i = 0; $i < $result->field_count; $i++)
                {
                    $line[] = trim($row[$i]); // Generamos un array con los datos de cada fila
                }
    
                $line = array_map('utf8_decode', $line); // Necesario para evitar error en codificación, por ejemplo, palabras con acentos
                fputcsv($fp, $line, ';'); // Agregamos la fila, delimitando con ';'
                unset($line); // Reseteamos el array para evitar duplicar la fila
            }
    
            fclose($fp);
            exit();
        }
    }
}