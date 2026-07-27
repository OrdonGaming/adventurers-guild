<?php

/* ==========================
Form Submission Setup
========================== */
$formSubmitted = ($_SERVER["REQUEST_METHOD"] === "POST");

$applicantName = "";
$applicantEmail = "";
$characterName = "";
$characterSpecies = "";
$characterClass = "";
$characterLevel = "";

$validSubmission = false;
$errorMessage = "";

if ($formSubmitted) {

    /* ==========================
    Retrieve Submitted Values
    ========================== */
    $submittedName = trim($_POST["name"] ?? "");
    $submittedEmail = trim($_POST["email"] ?? "");
    $submittedCharacterName = trim($_POST["character-name"] ?? "");
    $submittedCharacterSpecies = trim($_POST["character-species"] ?? "");
    $submittedCharacterClass = trim($_POST["character-class"] ?? "");
    $submittedCharacterLevel = trim($_POST["character-level"] ?? "");

    /* ==========================
    Validate Submitted Values
    ========================== */
    if (
        $submittedName === ""
        || $submittedEmail === ""
        || $submittedCharacterName === ""
        || $submittedCharacterSpecies === ""
        || $submittedCharacterClass === ""
        || $submittedCharacterLevel === ""
    ) {
        $errorMessage = "One or more required application fields were missing.";
    } elseif (!filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "The submitted email address was not valid.";
    } elseif (
        !filter_var($submittedCharacterLevel, FILTER_VALIDATE_INT)
        || (int) $submittedCharacterLevel < 1
        || (int) $submittedCharacterLevel > 20
    ) {
        $errorMessage = "The submitted character level must be between 1 and 20.";
    } else {
        $validSubmission = true;

        /* ==========================
        Safely Prepare Values
        ========================== */
        $applicantName = htmlspecialchars($submittedName, ENT_QUOTES, "UTF-8");
        $applicantEmail = htmlspecialchars($submittedEmail, ENT_QUOTES, "UTF-8");
        $characterName = htmlspecialchars($submittedCharacterName, ENT_QUOTES, "UTF-8");
        $characterSpecies = htmlspecialchars($submittedCharacterSpecies, ENT_QUOTES, "UTF-8");
        $characterClass = htmlspecialchars($submittedCharacterClass, ENT_QUOTES, "UTF-8");
        $characterLevel = htmlspecialchars($submittedCharacterLevel, ENT_QUOTES, "UTF-8");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- ==========================
Document Setup
========================== -->
<head>
    <meta charset="UTF-8">
    <meta name="description"
          content="Confirmation that an application to join The Adventurer's Guild has been successfully received for review.">
    <meta name="robots"
          content="noindex, nofollow">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Application Received | The Adventurer's Guild</title>
    <link rel="stylesheet"
          href="../global/css/style.css">
</head>
<body>

<!-- ==========================
Site Header
========================== -->
<header class="site-title">
    <a href="../home/index.html">
        <img src="../global/images/Adventurers%20Guild%20Symbol.jpg"
             alt="The Adventurer's Guild logo">
    </a>
    <div class="title-text">
        <a href="../home/index.html"
           class="site-title-link">
            <h1>The Adventurer's Guild</h1>
        </a>
        <p>Strength in Unity, Legacy in Action!</p>
    </div>
</header>

<!-- ==========================
Main Navigation
========================== -->
<nav class="nav-bar"
     aria-label="Main navigation">
    <ul>
        <li><a href="../home/index.html">Home</a></li>
        <li><a href="../about/about-index.html">About the Guild</a></li>
        <li><a href="../ranks/ranks-index.html">Guild Ranks</a></li>
        <li><a href="../locations/locations-index.html">Guild Locations</a></li>
        <li><a href="../quests/quests-index.html">Quest Board</a></li>
        <li><a href="../join/join-index.html" aria-current="page">Join the Guild</a></li>
        <li><a href="../resources/resources-index.html">Resources</a></li>
        <li><a href="../news/news-index.html">News</a></li>
    </ul>
</nav>

<!-- ==========================
Main Page Content
========================== -->
<main class="page-content">
    <section class="welcome-page">

<!-- ==========================
Confirmation Introduction
========================== -->
        <header class="welcome-intro">
            <h2 class="decorative-header">
                <span class="line"></span>
                <span class="star star-left"
                      aria-hidden="true">✦</span>
                Guild Application
                <span class="star star-right"
                      aria-hidden="true">✦</span>
                <span class="line"></span>
            </h2>
            <p>
                The Membership Office has received your submitted
                application information.
            </p>
        </header>

<!-- ==========================
Successful Submission
========================== -->
<?php if ($validSubmission): ?>
        <div class="welcome-card"
             role="status"
             aria-live="polite">
            <div class="welcome-seal"
                 aria-hidden="true">
                ✓
            </div>
            <h2>Application Received</h2>
            <p class="welcome-message">
                Welcome, <strong><?php echo $applicantName; ?></strong>!
            </p>
            <p>
                Your application has been delivered to the Guild
                Membership Office for review.
            </p>

<!-- ==========================
Submitted Information
========================== -->
            <dl class="welcome-summary">
                <div class="welcome-summary-row">
                    <dt>Applicant Name</dt>
                    <dd><?php echo $applicantName; ?></dd>
                </div>
                <div class="welcome-summary-row">
                    <dt>Email Address</dt>
                    <dd><?php echo $applicantEmail; ?></dd>
                </div>
                <div class="welcome-summary-row">
                    <dt>Character Name</dt>
                    <dd><?php echo $characterName; ?></dd>
                </div>
                <div class="welcome-summary-row">
                    <dt>Character Species</dt>
                    <dd><?php echo $characterSpecies; ?></dd>
                </div>
                <div class="welcome-summary-row">
                    <dt>Character Class</dt>
                    <dd><?php echo $characterClass; ?></dd>
                </div>
                <div class="welcome-summary-row">
                    <dt>Character Level</dt>
                    <dd>Level <?php echo $characterLevel; ?></dd>
                </div>
            </dl>
            <p class="welcome-note">
                Please review the information above. A guild
                representative may use the submitted email address
                to contact you about the next steps in the application
                process.
            </p>

<!-- ==========================
Confirmation Actions
========================== -->
            <div class="welcome-actions">
                <a href="join-index.html"
                   class="guild-button">
                    Submit Another Application
                </a>
                <a href="../quests/quests-index.html"
                   class="guild-button">
                    View the Quest Board
                </a>
            </div>
        </div>

<!-- ==========================
Invalid or Missing Submission
========================== -->
<?php else: ?>
        <div class="welcome-card welcome-error-card"
             role="alert">
            <div class="welcome-seal welcome-error-seal"
                 aria-hidden="true">
                !
            </div>
            <h2>Application Not Received</h2>
            <p>The Guild could not confirm the submitted application.</p>
            <p>
                <?php
                echo htmlspecialchars(
                    $errorMessage !== ""
                        ? $errorMessage
                        : "No application information was received.",
                    ENT_QUOTES,
                    "UTF-8"
                );
                ?>
            </p>
            <div class="welcome-actions">
                <a href="join-index.html"
                   class="guild-button">
                    Return to the Application
                </a>
            </div>
        </div>
<?php endif; ?>
    </section>
</main>

<!-- ==========================
Site Footer
========================== -->
<footer class="footer">
    <div class="footer-content">

        <!-- Adventurer Resources -->
        <section class="footer-section">
            <h2>Adventurer Resources</h2>
            <ul>
                <li><a href="../ranks/ranks-index.html">Guild Ranks</a></li>
                <li><a href="../quests/quests-index.html">Quest Board</a></li>
                <li><a href="../join/join-index.html">Join the Guild</a></li>
                <li><a href="../resources/resources-index.html">Guild Handbook</a></li>
            </ul>
        </section>

        <!-- Game Master Resources -->
        <section class="footer-section">
            <h2>GM Resources</h2>
            <ul>
                <li><a href="../locations/locations-index.html">Guild Locations</a></li>
                <li><a href="../resources/npc-directory.html">NPC Directory</a></li>
                <li><a href="../resources/quest-templates.html">Quest Templates</a></li>
                <li><a href="../resources/adventure-hooks.html">Adventure Hooks</a></li>
            </ul>
        </section>

        <!-- Guild Notices -->
        <section class="footer-section">
            <h2>Guild Notices</h2>
            <ul>
                <li><a href="../news/news-index.html#announcements">Latest Announcements</a></li>
                <li><a href="../news/news-index.html#expeditions">Upcoming Expeditions</a></li>
                <li><a href="../news/news-index.html#events">Guild Events</a></li>
                <li><a href="../resources/resources-index.html">Code of Conduct</a></li>
            </ul>
        </section>
    </div>
</footer>

<!-- ==========================
Copyright
========================== -->
<div class="copyright">
    <p>&copy; 2026 The Adventurer's Guild. All Rights Reserved.</p>
</div>
</body>
</html>