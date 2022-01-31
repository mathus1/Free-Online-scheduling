<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$past=strtotime("-2 Months");
$query1 = "SELECT * FROM events ORDER BY id";
$statement1 = $connect->prepare($query1);
$statement1->execute();
$result1 = $statement1->fetchAll();
foreach($result1 as $row1)
{
if (strtotime($row1['end_event']) < $past) {
  $query = "
  DELETE from events WHERE id=:id
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':id' =>$row1['id']
   )
  );
}}
 ?>

 <div class="w3-content w3-padding-32" style="max-width:720px;">
   <svg style="height:600px;" version="1.1" viewBox="0 0 338.1 332.95" >
    <defs>
     <linearGradient id="a" x1="-19.995" x2="203.4" y1="3.6414" y2="3.6414" gradientUnits="userSpaceOnUse">
      <stop style="stop-color:#e40000" offset="0"/>
      <stop style="stop-color:#1500ff" offset=".22748"/>
      <stop style="stop-color:#31ff7d" offset=".51124"/>
      <stop style="stop-color:#ffe911" offset=".66958"/>
      <stop style="stop-color:#ff0001" offset="1"/>
     </linearGradient>
    </defs>
    <g transform="translate(78.048 6.9585)">
     <path d="m-70.532 325.33c-2.8115-1.0044-4.8377-2.9113-6.6428-6.2516-0.846-1.5655-0.86885-4.8151-0.86885-123.57 0-134.12-0.233-123.88 2.8952-127.34 3.3047-3.6579 3.8841-3.7929 16.973-3.9548l11.599-0.14351v22.387l1.3719 2.1633c2.8999 4.5727 7.8876 6.5079 16.773 6.5079 8.8856 0 13.873-1.9352 16.773-6.5079l1.3719-2.1633v-22.329h43.181l0.0028 10.221c0.0013 5.9428 0.21228 10.99 0.5036 12.058 0.76133 2.792 4.5589 6.2634 8.2548 7.5458 3.5838 1.2435 11.32 1.7565 15.279 1.0132 6.052-1.1361 11.128-4.7214 12.212-8.6257 0.28112-1.0124 0.49277-6.1477 0.49424-11.992l0.0024-10.221h42.721v10.168c0 11.467 0.24181 12.821 2.8103 15.739 3.342 3.7968 9.3729 5.5961 17.402 5.1918 5.4005-0.27195 9.0991-1.3383 11.973-3.452 4.268-3.1387 4.564-4.2508 4.564-17.15v-10.497h43.181v22.329l1.3719 2.1633c2.8835 4.5468 7.8842 6.4843 16.773 6.4984 8.8786 0.0141 13.869-1.9194 16.773-6.4984l1.3719-2.1633v-22.387l11.599 0.14351c10.867 0.13445 11.715 0.20619 13.437 1.1368 2.1661 1.171 4.3819 3.4232 5.5758 5.6675 0.82802 1.5565 0.85532 5.5152 0.85532 124.03v122.42l-1.3663 2.4669c-1.5014 2.7108-3.4545 4.4328-6.0975 5.376-2.5256 0.90128-320.6 0.9175-323.12 0.0164zm306.26-15.384c2.0861-0.94758 4.1724-3.1849 4.6897-5.0289 0.45014-1.6049 0.45014-180 0-181.61-0.51722-1.844-2.6036-4.0813-4.6897-5.0289-1.7882-0.81227-7.1069-0.84365-144.62-0.85337-155.51-0.011-144.45-0.19298-147.25 2.4235-2.5305 2.3627-2.3743-3.8383-2.3743 94.263 0 98.09-0.15568 91.901 2.3713 94.261 2.7608 2.5777-8.1111 2.3998 147.15 2.4084 137.63 8e-3 142.93-0.023 144.72-0.83537z" style="fill:#2b2b2a;paint-order:normal"/>
     <path d="m-34.634 90.258c-2.4384-0.96255-4.7034-2.9511-5.779-5.0736l-1.1116-2.1935v-51.759l1.1636-2.3351c1.2386-2.4856 3.4394-4.303 6.1863-5.1086 7.1086-2.0849 14.626-0.02995 17.33 4.7368l1.042 1.8375-0.22644 54.35-1.4011 1.765c-0.77063 0.97074-2.5131 2.3335-3.8722 3.0283-2.2508 1.1507-2.9037 1.2607-7.3269 1.2341-2.6707-0.01601-5.3726-0.23312-6.0043-0.48246z" style="fill:#2b2b2a;paint-order:normal"/>
     <path d="m43.909 89.506c-1.3591-0.69479-3.1015-2.0575-3.8722-3.0283l-1.4011-1.765-0.12551-27.058c-0.12034-25.942-0.08904-27.129 0.75919-28.783 1.6395-3.1972 4.0937-4.7795 8.712-5.6169 7.0976-1.287 14.102 1.7597 15.609 6.7894 0.77733 2.5945 0.76235 51.378-0.01656 53.978-0.6689 2.2326-3.0234 4.7019-5.5984 5.8713-1.4509 0.6589-3.0001 0.85788-6.7398 0.86566-4.4029 0.0091-5.0863-0.10776-7.3269-1.2532z" style="fill:#2b2b2a;paint-order:normal"/>
     <path d="m124.08 89.819c-3.0814-1.5369-5.1908-3.9498-5.7636-6.5928-0.34419-1.5882-0.45917-10.404-0.35998-27.599 0.16104-27.919 7.9e-4 -26.429 3.1734-29.53 2.555-2.4979 8.0089-3.6994 12.915-2.845 3.5826 0.62389 6.0176 1.9434 7.9008 4.2816l1.4218 1.7653v55.413l-1.4011 1.7653c-0.77063 0.9709-2.5131 2.3337-3.8722 3.0285-2.245 1.1477-2.9152 1.2616-7.3268 1.245-3.9007-0.01471-5.2161-0.19799-6.6873-0.93177z" style="fill:#2b2b2a;paint-order:normal"/>
     <path d="m203.55 89.677c-2.6741-1.261-4.0406-2.6153-5.0311-4.986-0.61341-1.4681-0.71097-5.2832-0.71097-27.803v-26.101l1.0336-2.0496c3.6416-7.2215 18.249-7.8237 23.079-0.9514l1.3823 1.9668v54.507l-1.386 1.972c-0.86518 1.231-2.3089 2.4541-3.8422 3.2551-2.2425 1.1715-2.8815 1.2828-7.342 1.2787-4.1715-0.0037-5.2216-0.16284-7.1826-1.0876z" style="fill:#2b2b2a;paint-order:normal"/>
     <path d="m44.378 140.38v-16.537h43.64v33.075h-43.64z" style="fill:#c02b2a;paint-order:normal" class="grow"/>
     <path d="m92.152 140.38v-16.537h43.64v33.075h-43.64z" style="fill:#2bd32a;paint-order:normal" class="grow"/>
     <path d="m139.93 140.38v-16.537h43.64v33.075h-43.64z" style="fill:#2b2bee;paint-order:normal" class="grow"/>
     <path d="m187.7 140.38v-16.537h43.64v33.075h-43.64z" style="fill:#2bd3e2;paint-order:normal" class="grow"/>
     <path d="m187.7 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#2bd32a;paint-order:normal" class="grow"/>
     <path d="m139.93 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#f9b0b3;paint-order:normal" class="grow"/>
     <path d="m92.152 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#5a5e58;paint-order:normal" class="grow"/>
     <path d="m44.378 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#b82cfa;paint-order:normal" class="grow"/>
     <path d="m-3.3965 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#cdffdd;paint-order:normal" class="grow"/>
     <path d="m-51.171 177.13v-16.537h43.64v33.074h-43.64z" style="fill:#f1ff2a;paint-order:normal" class="grow"/>
     <path d="m-51.171 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#c02b2a;paint-order:normal" class="grow"/>
     <path d="m-3.3965 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#f9b0b3;paint-order:normal" class="grow"/>
     <path d="m44.378 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#2b8dff;paint-order:normal" class="grow"/>
     <path d="m92.152 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#925b2a;paint-order:normal" class="grow"/>
     <path d="m139.93 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#2b2b98;paint-order:normal" class="grow"/>
     <path d="m187.7 213.42v-16.537h43.64v33.075h-43.64z" style="fill:#f8b82a;paint-order:normal" class="grow"/>
     <path d="m187.7 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#ff2bc7;paint-order:normal" class="grow"/>
     <path d="m139.93 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#d2a1fd;paint-order:normal" class="grow"/>
     <path d="m92.152 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#2b2b2a;paint-order:normal" class="grow"/>
     <path d="m44.378 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#2ba2be;paint-order:normal" class="grow"/>
     <path d="m-3.3965 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#e35737;paint-order:normal" class="grow"/>
     <path d="m-51.171 250.17v-16.537h43.64v33.074h-43.64z" style="fill:#d6d8d6;paint-order:normal" class="grow"/>
     <path d="m-51.171 286.92v-16.537h43.64v33.074h-43.64z" style="fill:#beffff;paint-order:normal" class="grow"/>
     <path d="m-3.3965 286.92v-16.537h43.64v33.074h-43.64z" style="fill:#2b662a;paint-order:normal" class="grow"/>
     <path d="m44.378 286.92v-16.537h43.64v33.074h-43.64z" style="fill:#accaca;paint-order:normal" class="grow"/>
     <path d="m92.152 286.92v-16.537h43.64v33.074h-43.64z" style="fill:#b8c6fa;paint-order:normal" class="grow"/>
     <path d="m140.03 286.92v-16.537h43.64v33.074h-43.64z" style="fill:#55b5dc;paint-order:normal" class="grow"/>
     <text x="-21.086149" y="9.4897833" style="fill:url(#a);font-family:Arial;font-size:50.8px;letter-spacing:0px;line-height:1.25;stroke-width:.26458;word-spacing:0px" xml:space="preserve"><tspan x="-21.086149" y="9.4897833" style="fill:url(#a);font-size:22.578px;stroke-width:.26458">Online Scheduling tool</tspan></text>
    </g>
   </svg>

 </div>

<?php include 'includes/footer.php'; ?>
