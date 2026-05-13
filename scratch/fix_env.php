<?php
$env = file_get_contents('.env');
$lines = explode("\n", $env);
$newLines = [];
foreach ($lines as $line) {
    if (strpos($line, 'VITE_APP_NAME') !== false) {
        $newLines[] = $line;
        break;
    }
    $newLines[] = $line;
}

$append = "
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL=\"\${APP_URL}/auth/google/callback\"

GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GITHUB_REDIRECT_URL=\"\${APP_URL}/auth/github/callback\"

FIREBASE_CREDENTIALS=storage/app/firebase-auth.json
FIREBASE_API_KEY=
FIREBASE_AUTH_DOMAIN=
FIREBASE_PROJECT_ID=
FIREBASE_STORAGE_BUCKET=
FIREBASE_MESSAGING_SENDER_ID=
FIREBASE_APP_ID=";

file_put_contents('.env', implode("\n", $newLines) . $append);
echo "Fixed .env";
