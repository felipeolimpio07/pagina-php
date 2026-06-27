\\ felipe Olimpio	
\\comite
<?php

// Versão do MySQL
$mysql_version = "---";
try {
    $link = @mysqli_connect("localhost", "root", "");
    if ($link) {
        $mysql_version = mysqli_get_server_info($link);
        mysqli_close($link);
    }
} catch (Exception $e) { $mysql_version = "Erro"; }

// Listagem de Projetos por Data
$dir = ".";
$projects = [];
$ignored = ['.', '..', '.git', 'assets', 'css', 'js', 'phpmyadmin'];

foreach (scandir($dir) as $item) {
    if (is_dir($item) && !in_array($item, $ignored)) {
        $projects[$item] = filemtime($item);
    }
}
arsort($projects); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>DevPanel | Laragon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --primary-purple: #6a1b9a; /* Roxo vibrante */
            --dark-purple: #4a148c;    /* Roxo profundo */
            --light-bg: #f3f0f7;       /* Fundo levemente arroxeado */
            --white: #ffffff;
        }

        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--light-bg); margin: 0; color: #444; }
        
        /* Header */
        header { 
            background: var(--dark-purple); 
            padding: 1.2rem 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .logo-container { display: flex; align-items: center; gap: 15px; }
        .logo-box { 
            background: rgba(255,255,255,0.1); 
            border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        /* Dashboard Stats */
        .dashboard { padding: 2rem 5%; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.2rem; }
        .stat-card { 
            background: var(--white); 
            padding: 1.5rem; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(106, 27, 154, 0.05);
            border-bottom: 4px solid var(--primary-purple);
        }
        .stat-card i { color: var(--primary-purple); margin-bottom: 10px; font-size: 1.2rem; }
        .stat-card h4 { margin: 0; color: #888; font-size: 0.75rem; text-transform: uppercase; }
        .stat-card p { margin: 5px 0 0; font-size: 1.1rem; font-weight: 700; color: var(--dark-purple); }

        /* Links Úteis */
        .links-bar { padding: 0 5%; margin-bottom: 2rem; display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { 
            text-decoration: none; 
            padding: 10px 20px; 
            background: var(--white); 
            color: var(--primary-purple); 
            border: 1.5px solid var(--primary-purple);
            border-radius: 25px; 
            font-size: 14px; 
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover { background: var(--primary-purple); color: var(--white); transform: translateY(-2px); }

        /* Projetos */
        .projects-sec { padding: 0 5% 5rem; }
        h2 { color: var(--dark-purple); border-left: 5px solid var(--primary-purple); padding-left: 15px; margin-bottom: 1.5rem; }
        .project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .project-card { 
            background: var(--white); 
            padding: 1.5rem; 
            border-radius: 12px; 
            text-decoration: none; 
            color: inherit; 
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid transparent;
        }
        .project-card:hover { 
            border-color: var(--primary-purple);
            box-shadow: 0 10px 20px rgba(106, 27, 154, 0.1);
        }
        .project-card h3 { margin: 0; color: var(--dark-purple); font-size: 1.25rem; }
        .project-card .date { font-size: 0.8rem; color: #aaa; margin-top: 10px; display: flex; align-items: center; gap: 5px; }
    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <div class="logo-box">
            <i class="fas fa-code"></i> LOCALHOST
        </div>
    </div>
    <div style="text-align: right">
        <div style="font-size: 1.2rem; font-weight: bold;"><?php echo date('H:i'); ?></div>
        <div style="font-size: 0.8rem; opacity: 0.8;"><?php echo date('d/m/Y'); ?></div>
    </div>
</header>

<section class="dashboard">
    <div class="stat-card">
        <i class="fas fa-server"></i>
        <h4>Servidor</h4>
        <p><?php echo explode(' ', $_SERVER['SERVER_SOFTWARE'])[0]; ?></p>
    </div>
    <div class="stat-card">
        <i class="fab fa-php"></i>
        <h4>Versão PHP</h4>
        <p><?php echo phpversion(); ?></p>
    </div>
    <div class="stat-card">
        <i class="fas fa-database"></i>
        <h4>MySQL</h4>
        <p><?php echo $mysql_version; ?></p>
    </div>
    <div class="stat-card">
        <i class="fas fa-folder-open"></i>
        <h4>Projetos</h4>
        <p><?php echo count($projects); ?></p>
    </div>
    <div class="stat-card">
        <i class="fas fa-hard-drive"></i>
        <h4>Disco (C:)</h4>
        <p><?php echo $disk_usage; ?>% uso</p>
    </div>
</section>

<div class="links-bar">
    <a href="/phpmyadmin" target="_blank" class="btn"><i class="fas fa-database"></i> phpMyAdmin</a>
    <a href="http://localhost" class="btn"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="https://github.com" target="_blank" class="btn"><i class="fab fa-github"></i> GitHub</a>
</div>

<section class="projects-sec">
    <h2><i class="fas fa-rocket"></i> Projetos Recentes</h2>
    <div class="project-grid">
        <?php foreach ($projects as $name => $time): ?>
        <a href="/<?php echo $name; ?>" class="project-card">
            <h3><?php echo ucfirst($name); ?></h3>
            <div class="date">
                <i class="far fa-calendar-alt"></i> 
                <?php echo date("d M, Y • H:i", $time); ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
</section>

    <footer style="background: var(--dark-purple); color: rgba(255,255,255,0.7); padding: 2rem 5%; margin-top: 4rem; text-align: center;">
        <div style="margin-bottom: 10px;">
            <i class="fas fa-code" style="color: var(--white); margin-right: 10px;"></i>
            <strong>Rafael Popovicz</strong>
        </div>
        <div style="font-size: 0.85rem;">
            &copy; <?php echo date('Y'); ?> - Desenvolvido em PHP & MariaDB no Laragon. 
            <br>
            <span style="opacity: 0.5;">Ambiente de Desenvolvimento Local</span>
        </div>
    </footer>

</body>
</html>
</body>
</html>
