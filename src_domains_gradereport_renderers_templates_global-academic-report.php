<?php

declare(strict_types=1);

use phpapi\components\session\Reflection;
use phpapi\sdks\scms\klass\models\AdminClass;

/**
 * @var Reflection $owner
 * @var array $results
 * @var array $reviews
 * @var array $grouped_results
 * @var array $statis_results
 * @var AdminClass $admin_class
 * @var bool $downloading
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>学业报告单</title>
  </head>
  <style>
    @page {
      margin: 10px;
    }

    td,
    thead {
      page-break-inside: avoid !important;
    }
    @media print {
      .sz-report-sheet td {
        page-break-inside: avoid !important;
      }
    }
    .sz-report-sheet {
      font-family: 'Noto Sans CJK SC', sans-serif;
      color: #060c19;
      text-align: center;
      margin: auto;
      width: 100%;
    }

    .sz-report-sheet h1 {
      margin: auto;
      height: 90px;
      line-height: 90px;
      padding: 0;
      font-size: 24px;
      font-weight: 600;
      border: 1px rgba(50, 56, 66, 0.1) solid;
      border-bottom: none;
    }

    .sz-report-sheet table {
      border-collapse: collapse;
      margin: auto;
      width: 100%;
    }

    .sz-report-sheet thead tr td {
      font-weight: 600;
      background-color: rgb(236, 244, 255);
    }

    .sz-report-sheet tr td {
      border: 1px rgba(50, 56, 66, 0.1) solid;
      font-weight: 400;
      padding: 5px 5px;
    }

    .sz-report-sheet tfoot tr {
      height: 120px;
    }
    .sz-report-sheet .title {
      background-color: #f5f9ff;
    }
    .sz-report-sheet .border {
      border: 1px rgba(50, 56, 66, 0.1) solid;
    }
    .sz-report-sheet .block {
      background-color: #f5f9ff;
      flex: 1;
      border-radius: 6%;
      margin: 16px 8px;
      max-width: 199px;
      min-width: 100px;
    }
    .sz-report-sheet .flex-wrapper {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
    }
    .sz-report-sheet .block .score {
      font-size: 20px;
      font-weight: 600;
      max-width: 199px;
      height: 55px;
      padding: 5px 0 0 0;
    }
    .sz-report-sheet .block .score .item {
      font-size: 14px;
      display: block;
      font-weight: 400;
    }
  </style>
  <body>
    <div class="sz-report-sheet">
      <div class="border"><h2>深圳中学学生总学业报告单</h2></div>

      <div class="border flex-wrapper"  style="border-top: none; border-bottom: none">
        <div class="block">
          <div class="score">
          <?= $statis_results['total_credit'] ?> <br /><span class="item">获得总学分</span>
          </div>
        </div>
        <div class="block">
          <div class="score"><?= $statis_results['total_credit_has_gpa'] ?> <br /><span class="item">有绩点学分</span></div>
        </div>
        <div class="block">
          <div class="score">
          <?= $statis_results['total_credit_no_gpa'] ?> <br /><span class="item">合格认定学分</span>
          </div>
        </div>
        <div class="block">
          <div class="score">
          <?= $statis_results['total_credit_gpa'] ?> <br />
            <span class="item">总学分绩点</span>
          </div>
        </div>
        <div class="block">
          <div class="score">
          <?= $statis_results['avg_credit_gpa'] ?> <br />
            <span class="item">平均学分绩点</span>
          </div>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <td style="width: 10.84%" colspan="2">姓名</td>
            <td style="width: 32.42%" colspan="2"><?= $owner['name'] ?></td>
            <td style="width: 18.76%" colspan="2">学号</td>
            <td style="width: 37.98%" colspan="6"><?= $owner['usin'] ?></td>
          </tr>
          <tr>
            <td style="width: 5.42%">领域</td>
            <td>科目</td>
            <td>课程</td>
            <td>模块</td>
            <td>课程类型</td>
            <td>修习阶段</td>

            <td style="width: 7.25%">模块综合分</td>
            <td style="width: 5.35%">模块综合等级</td>
            <td style="width: 5.26%">获得学分</td>
            <td style="width: 5.26%">模块综合等级值</td>
            <td style="width: 5.26%">学分绩点</td>
            <td style="width: 9.61%">任课教师</td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($grouped_results as $domain => $subjectResults): ?>
          <?php $domainCounter = 0; ?>
          <?php foreach ($subjectResults as $subject => $rows): ?>
            <?php $subjectCounter = 0; ?>
            <?php foreach ($rows as $row): ?>
              <tr>
                <?php if ($domainCounter === 0): ?>
                  <td class="title" rowspan="<?= collect($results)->where('class.domain.name', $domain)->count() ?>"><?= $domain ?></td>
                <?php endif; ?>
                <?php if ($subjectCounter === 0): ?>
                  <td class="title" rowspan="<?= collect($results)->where('class.subject.name', $subject)->count()  ?>"><?= $subject ?></td>
                <?php endif; ?>
                <td><?= $row['class']['name']  ?? '' ?></td>
                <td><?= $row['class']['module'] ?? '' ?></td>
                <td><?= $row['class']['attribute']['name'] ?? '' ?></td>
                <td><?= $row['class']['stage'] ?? '' ?></td>
                <td><?= $row['grade']['score'] ?? '' ?></td>
                <td><?= $row['grade']['level'] ?? '-' ?></td>
                <td><?= $row['grade']['credit'] ?? 0 ?></td>
                <td><?= $row['grade']['gpa'] ?? '-' ?></td>
                <td><?= $row['grade']['credit_gpa'] ?? '-' ?></td>
                <td><?= $row['grade']['teachers'] ?? '-' ?></td>
              </tr>
              <?php
                 $domainCounter++;
                 $subjectCounter++;
              ?>
            <?php endforeach; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>

        <?php foreach ($reviews as $review): ?>
        <tr>
          <td colspan="9" style="height: 80px">
            <div style="display: inline-block; margin: 20px">
            <?= $review['semester']->name ?? '' ?>评语：<?= $review['review'] ?>
            </div>
          </td>
          <td colspan="3">评语老师：<?= $review['teachers'] ?? '' ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </body>
</html>
