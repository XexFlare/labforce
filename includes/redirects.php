<?php
function redirect()
{
  if (isset($_GET['id']) && !isset($_GET['rd'])) {
    switch ($_GET['id']) {
      case '757':
        header('Location: http://labforce.meridiancommodities.com/analysis_report.php?id=757&rd');
        break;
      case '797':
        header('Location: https://labforce.meridiancommodities.com/analysis_report.php?id=810&rd');
        break;
      case '798':
        header('Location: https://labforce.meridiancommodities.com/analysis_report.php?id=810&rd');
        break;
      default:
        return false;
        break;
    }
    return true;
  }
}
