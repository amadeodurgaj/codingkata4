<?php
session_start();
require_once 'dbconnect.php';

// Fetch all categories
$categorySql = 'SELECT categoryid, name FROM "taskcategory" ORDER BY categoryid';
$categoryStmt = $pdo->query($categorySql);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Get current user ID if logged in
$currentUserId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;

// Function to get leaderboard for a specific category
function getLeaderboardByCategory($pdo, $categoryId)
{
    $sql = 'SELECT u.userid, u.email, p.firstname, p.lastname, p.xp, p.profilepicture
            FROM "user" u
            JOIN "profile" p ON u.userid = p.userid
            WHERE p.category = ?
            ORDER BY p.xp DESC
            LIMIT 10';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Returns an ordinal number string (1st, 2nd, etc.)
 */
function ordinal($number)
{
    if (($number % 100) >= 11 && ($number % 100) <= 13) {
        return $number . 'th';
    }
    switch ($number % 10) {
        case 1:
            return $number . 'st';
        case 2:
            return $number . 'nd';
        case 3:
            return $number . 'rd';
        default:
            return $number . 'th';
    }
}

/**
 * Calculate level and progress based on XP
 * Users start at level 1 with 0 XP
 * Each level requires 100 XP to complete
 * Examples:
 * - 0-99 XP = Level 1
 * - 100-199 XP = Level 2
 * - 200-299 XP = Level 3, etc.
 */
function calculateLevelAndProgress($xp) {
    $xp = (int)$xp; // Ensure it's an integer
    
    if ($xp < 0) {
        return ['level' => 1, 'xpInLevel' => 0, 'progressPercent' => 0];
    }
    
    // Calculate level: 0-99 XP = Level 1, 100-199 XP = Level 2, etc.
    $level = intval($xp / 100) + 1;
    
    // Calculate XP progress within current level
    $xpInLevel = $xp % 100;
    
    // Progress percentage (0-99)
    $progressPercent = $xpInLevel;
    
    return [
        'level' => $level,
        'xpInLevel' => $xpInLevel,
        'progressPercent' => $progressPercent
    ];
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestenliste - TaskQuest</title>
    <?php include("header.php"); ?>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .leaderboard-container {
            max-width: 1400px;
            margin: 120px auto 40px;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            color: white;
            font-size: 2.5rem;
            margin-bottom: 50px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 1s ease-out;
        }

        .leaderboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(600px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .category-leaderboard {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.8s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-leaderboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .category-title {
            text-align: center;
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
            position: relative;
        }

        .category-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .player-card {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 12px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .player-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .player-card.current-user {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
            font-weight: bold;
        }

        .player-card.rank-1 {
            background: linear-gradient(45deg, #ffd700, #ffed4a);
            color: #2c3e50;
        }

        .player-card.rank-2 {
            background: linear-gradient(45deg, #c0c0c0, #e0e0e0);
            color: #2c3e50;
        }

        .player-card.rank-3 {
            background: linear-gradient(45deg, #cd7f32, #daa520);
            color: white;
        }

        .rank-number {
            font-size: 1.2rem;
            font-weight: bold;
            min-width: 40px;
            text-align: center;
            margin-right: 15px;
        }

        .player-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            border: 3px solid rgba(255, 255, 255, 0.8);
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .player-avatar:hover {
            transform: scale(1.1);
        }

        .default-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 15px;
            border: 3px solid rgba(255, 255, 255, 0.8);
        }

        .player-info {
            flex: 1;
        }

        .player-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .player-stats {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .level-badge {
            background: rgba(0, 0, 0, 0.1);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .xp-progress {
            flex: 1;
            margin-left: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            transition: width 1s ease-out;
            position: relative;
            min-width: 0;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        .progress-text {
            font-size: 0.7rem;
            margin-top: 2px;
            text-align: center;
        }

        .total-xp {
            font-weight: bold;
            color: #667eea;
            margin-left: 10px;
        }

        .empty-category {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
            font-style: italic;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @media (max-width: 768px) {
            .leaderboard-grid {
                grid-template-columns: 1fr;
            }

            .leaderboard-container {
                margin: 80px auto 20px;
                padding: 15px;
            }

            .page-title {
                font-size: 2rem;
                margin-bottom: 30px;
            }

            .player-card {
                padding: 12px;
            }

            .player-avatar,
            .default-avatar {
                width: 40px;
                height: 40px;
                margin-right: 12px;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php require_once("navbar.php"); ?>
    </header>

    <div class="container leaderboard-container">
        <h1 class="page-title">🏆 Bestenliste</h1>

        <div class="leaderboard-grid">
            <?php foreach ($categories as $category) : ?>
                <?php
                $players = getLeaderboardByCategory($pdo, $category['categoryid']);
                ?>
                <div class="category-leaderboard" data-category="<?= $category['categoryid'] ?>">
                    <h2 class="category-title"><?= htmlspecialchars($category['name']) ?></h2>

                    <?php if (empty($players)) : ?>
                        <div class="empty-category">
                            <p>Noch keine Spieler in dieser Kategorie</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($players as $index => $player) : ?>
                            <?php
                            $rank = $index + 1;
                            $isCurrentUser = $currentUserId !== null && $currentUserId == $player['userid'];

                            $xpTotal = (int)$player['xp'];
                            $levelData = calculateLevelAndProgress($xpTotal);
                            $calculatedLevel = $levelData['level'];
                            $xpInLevel = $levelData['xpInLevel'];
                            $progressPercent = $levelData['progressPercent'];
                            
                            // Debug: uncomment the line below to see actual XP values
                            // echo "<!-- DEBUG: " . htmlspecialchars($displayName) . " has " . $xpTotal . " XP, calculated level: " . $calculatedLevel . " -->";

                            $displayName = trim($player['firstname'] . ' ' . $player['lastname']);
                            if (empty($displayName)) {
                                $displayName = explode('@', $player['email'])[0];
                            }

                            $cardClass = 'player-card';
                            if ($isCurrentUser) $cardClass .= ' current-user';
                            elseif ($rank === 1) $cardClass .= ' rank-1';
                            elseif ($rank === 2) $cardClass .= ' rank-2';
                            elseif ($rank === 3) $cardClass .= ' rank-3';
                            ?>
                            <div class="<?= $cardClass ?>" data-rank="<?= $rank ?>">
                                <div class="rank-number"><?= ordinal($rank) ?></div>

                                <?php if (!empty($player['profilepicture'])) : ?>
                                    <?php
                                    // The database stores paths like "/img/filename.ext"
                                    // We need to remove the leading slash for web paths
                                    $dbPath = $player['profilepicture'];
                                    
                                    // Remove leading slash if present
                                    $webPath = ltrim($dbPath, '/');
                                    
                                    // Check if file exists in the filesystem
                                    $fileExists = file_exists($webPath);
                                    
                                    if ($fileExists) {
                                        $picturePath = htmlspecialchars($webPath);
                                        ?>
                                        <img src="<?= $picturePath ?>" alt="<?= htmlspecialchars($displayName) ?>" class="player-avatar" 
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="default-avatar" style="display: none;">
                                            <?= strtoupper(substr($displayName, 0, 1)) ?>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="default-avatar">
                                            <?= strtoupper(substr($displayName, 0, 1)) ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                <?php else : ?>
                                    <div class="default-avatar">
                                        <?= strtoupper(substr($displayName, 0, 1)) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="player-info">
                                    <div class="player-name"><?= htmlspecialchars($displayName) ?></div>
                                    <div class="player-stats">
                                        <span class="level-badge">Level <?= $calculatedLevel ?></span>
                                        <div class="xp-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" data-progress="<?= $progressPercent ?>" style="width: 0%;"></div>
                                            </div>
                                            <div class="progress-text"><?= $xpInLevel ?>/100 XP</div>
                                        </div>
                                        <span class="total-xp"><?= number_format($xpTotal) ?> XP</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');

            // Animate progress bars after page load
            setTimeout(() => {
                progressBars.forEach(bar => {
                    const percent = bar.getAttribute('data-progress');
                    bar.style.width = percent + '%';
                });
            }, 500);
        });
    </script>
</body>

</html>