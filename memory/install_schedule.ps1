<#
  install_schedule.ps1 — register (or remove) the daily decision-review check
  as a Windows Scheduled Task. Windows has no cron; this is the equivalent.

  Install:    powershell -ExecutionPolicy Bypass -File memory\install_schedule.ps1
  Uninstall:  powershell -ExecutionPolicy Bypass -File memory\install_schedule.ps1 -Uninstall
  Run now:    Start-ScheduledTask -TaskName "KonnectYatra Decision Reviews"
#>
param(
  [switch]$Uninstall,
  [string]$Time = "09:00"
)

$TaskName = "KonnectYatra Decision Reviews"

if ($Uninstall) {
  Unregister-ScheduledTask -TaskName $TaskName -Confirm:$false
  Write-Host "Removed scheduled task '$TaskName'."
  return
}

# Locate Git Bash.
$bash = @(
  "C:\Program Files\Git\bin\bash.exe",
  "C:\Program Files\Git\usr\bin\bash.exe",
  "$env:LOCALAPPDATA\Programs\Git\bin\bash.exe"
) | Where-Object { Test-Path $_ } | Select-Object -First 1

if (-not $bash) { throw "Could not find Git bash.exe. Edit this script with its path." }

# Script path in msys form (e.g. d:\...\check_reviews.sh -> /d/.../check_reviews.sh).
$scriptWin  = Join-Path $PSScriptRoot "check_reviews.sh"
$drive      = $scriptWin.Substring(0,1).ToLower()
$scriptMsys = "/$drive" + ($scriptWin.Substring(2) -replace "\\", "/")
$logMsys    = $scriptMsys -replace "check_reviews\.sh$", "check_reviews.log"

$action  = New-ScheduledTaskAction -Execute $bash -Argument "-lc `"$scriptMsys >> $logMsys 2>&1`""
$trigger = New-ScheduledTaskTrigger -Daily -At ([datetime]$Time)

Register-ScheduledTask -TaskName $TaskName -Action $action -Trigger $trigger `
  -Description "Daily: flag KonnectYatra decisions that have reached their 30-day review date." `
  -Force | Out-Null

Write-Host "Registered '$TaskName' to run daily at $Time."
Write-Host "Test it now with: Start-ScheduledTask -TaskName `"$TaskName`""
