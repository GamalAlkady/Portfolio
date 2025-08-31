# PowerShell script to adjust font sizes
param($filePath)

# Read file content
$content = Get-Content $filePath -Raw

# Step 1: Change base font-size to 100%
$content = $content -replace 'font-size:\s*62\.5%', 'font-size: 100%'

# Step 2: Adjust all rem values (multiply by 0.625)
$content = [regex]::Replace($content, '([\d.]+)rem', {
    param($match)
    $value = [double]::Parse($match.Groups[1].Value)
    $newValue = $value * 0.625
    # Format to max 4 decimal places and trim trailing zeros
    "{0:0.#####}" -f $newValue + "rem"
})

# Write back to file
Set-Content -Path $filePath -Value $content