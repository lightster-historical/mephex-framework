#!/usr/bin/env php
<?php
// dumps database tables into the designated format



function bootstrap()
{
	require_once 'Mephex/App/AutoLoader.php';
	require_once 'Mephex/App/Class/Loader/PathOriented.php';
	
	define('ENV_USER', $_ENV['USER']);

	$auto_loader	= Mephex_App_AutoLoader::getInstance();
	$auto_loader->addClassLoader(new Mephex_App_Class_Loader_PathOriented('Mephex_'));
	$auto_loader->registerSpl();
	
	$options	= getopt('f:c:d:g:t:');
	$config		= getConfig($options);
	$format		= getOutputFormat($options);
	$group		= getGroupName($options);
	$conn_name	= getConnectionName($options);
	
	$factory	= new Mephex_Db_Sql_ConnectionFactory();
	$conn		= $factory->connectUsingConfig($config, $group, $conn_name);
	
	$tables		= getTables($options);

	$exporter	= new Mephex_Db_Exporter_PhpUnit_XmlDataSet($conn);
	foreach($tables as $table)
	{
		$exporter->addTable($table);
	}
	$exporter->export('php://stdout');
}



function getConfig(array $options)
{
	if(!isset($options['c']))
	{
		die("Configuration file (-c) not provide.\n");
	}
	
	$config	= new Mephex_Config_OptionSet();
	$config->addLoader(new Mephex_Config_Loader_Ini($options['c']));
	
	return $config;
}
	


function getOutputFormat(array $options)
{
	if(!isset($options['f']))
	{
		die("Output format (-f) not provided.\n");
	}
	
	$known	= array(
		'xml'	=> 'xml'
	);
	if(isset($known[$options['f']]))
	{
		return $known[$options['f']];
	}
	
	die("Unknown output format: {$options['f']}.\n");
}



function getGroupName(array $options)
{
	return (
		isset($options['g']) 
			? $options['g']
			: 'database'
	);
}



function getConnectionName(array $options)
{
	if(!isset($options['d']))
	{
		die("Database connection name (-d) not provided.\n");
	}
	
	return $options['d'];
} 



function getTables(array $options)
{
	if(!isset($options['t']))
	{
		die("Database table names (-t) not provided.\n");
	}
	
	return explode(' ', $options['t']);
}



bootstrap();