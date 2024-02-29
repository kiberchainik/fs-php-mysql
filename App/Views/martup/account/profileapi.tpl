<!-- ...:::: Start Account Dashboard Section:::... -->
<div class="account-dashboard section-fluid-270 section-top-gap-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <?=$profilemenu?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <?php if($userDate['type_person'] == '4'): ?>
                <div class="col-md-12 col-sm-12 mb-20">
                    <div class="form_api_data">
                        <?php if(isset($isAccessIsset['id'])):?>
                        <div id="secret_key">
                            <i>Secret key:</i><pre><?=$isAccessIsset['secret_key']?></pre>
                        </div>
                        <div id="token">
                            <i>Token:</i><pre><?=$isAccessIsset['token']?></pre>
                        </div>
                        <div class="default-form-box">
                            <input type="password" name="pass" id="pass" />
                        </div>
                        <div id="result" class="single-checkout-box"></div>
                        <a class="btn btn-sm btn-radius btn-default mb-4 api_access">Update API access</a>
                        <?php else: ?>
                        <div id="secret_key">
                            <i>Secret key:</i>
                        </div>
                        <div id="token">
                            <i>Token:</i>
                        </div>
                        <div class="default-form-box">
                            <input type="password" name="pass" id="pass" />
                        </div>
                        <div id="result" class="single-checkout-box"></div>
                        <a class="btn btn-sm btn-radius btn-default mb-4 api_access">Create API access</a>
                        <?php endif ?>
                    </div>
                    <div class="col-md-12 col-sm-12"></div>
                    <script>
                        $(document).ready(function() {
                            $('.api_access').on('click', function (e){
                                e.preventDefault();
                                
                                //$('#secret_key').empty();
                                //$('#token').empty();
                                $('#result').empty();
                                
                                var password = $('#pass').val();
                                if(password == '') {
                                    $('#pass').before('Insert password');
                                    return false;
                                }
                                
                                $.ajax({
                                    url: '/profile/api_access',
                                    type:'post',
                                    data: {pass: password},
                                    dataType: 'json',
                                    success: function (result) {
                                        $('#result').html(result);
                                        if(result.secret_key) {
                                            $('#secret_key').append('<pre>'+result.secret_key+'</pre>');
                                            $('#token').append('<pre>'+result.token+'</pre>');
                                        } else {
                                            $('#result').html('<pre>'+result+'</pre>');
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                </div>
                <div class="col-md-12 api_instruction">
                    <script type="text/javascript" src="https://cdnjs.com/libraries/prettify"></script>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="exemple_connection-tab" data-bs-toggle="tab" data-bs-target="#exemple_connection" type="button" role="tab" aria-controls="exemple_connection" aria-selected="true">Exemple connection</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab" aria-controls="users" aria-selected="false">Users</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="branch-tab" data-bs-toggle="tab" data-bs-target="#branch" type="button" role="tab" aria-controls="branch" aria-selected="false">Branch</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="vacancy-tab" data-bs-toggle="tab" data-bs-target="#vacancy" type="button" role="tab" aria-controls="vacancy" aria-selected="false">Vacancy</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="exemple_connection" role="tabpanel" aria-labelledby="exemple_connection-tab">
<pre class="prettyprint lang-js">
$request = '{
"name":"AllCustomers",
"param":{
    "secret_key":"your_secret_key"
    }
}';
</pre>
<pre class="prettyprint lang-js">
$curl = curl_init();
curl_setopt_array($curl, array (
CURLOPT_URL => "https://api.findsol.it/",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => $request,
CURLOPT_HTTPHEADER => array (
    "authorization: Bearer $token", //$token - is your token
    "content-type: application/json",
),
));

$response = curl_exec($curl);
$err = curl_error($curl);

if ($err) echo "cURL Error #:" . $err;
else echo $response;

curl_close($curl);
</pre>
                        </div>
                        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                            <table class="table mt-10">
                                <thead>
                                    <tr>
                                        <th>Function name</th>
                                        <th>Description</th>
                                        <th>Request param</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>{AllCustomers}</code></td>
                                        <td>Get all users on FindSolution</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"AllCustomers",
"param":{
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{getCustomerPortfolio}</code></td>
                                        <td>Get portfolio of user with customerId</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"getCustomerPortfolio",
"param":{
    "customerId":"userId",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{getCustomerCandidats}</code></td>
                                        <td>Get all candidats for vacance</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"getCustomerCandidats",
"param":{
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="branch" role="tabpanel" aria-labelledby="branch-tab">
                            <table class="table mt-10">
                                <thead>
                                    <tr>
                                        <th>Function name</th>
                                        <th>Description</th>
                                        <th>Request param</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>{newBranch}</code></td>
                                        <td>Adding a new branch</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"newBranch",
"param":{
    "name_company":"Company name",
    "adres":"Adres company",
    "phone":"Phone company",
    "email":"Email",
    "url_company":"Url company",
    "img":"Logo company",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{getBranchList}</code></td>
                                        <td>Get a list of all branches</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"getBranchList",
"param":{
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{updateBranch}</code></td>
                                        <td>Updating/Changing branch data</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"updateBranch",
"param":{
    "id":"179",
    "name_company":"Update branch",
    "adres":"Italia, Treviso, Veneto",
    "phone":"0123456789",
    "email":"box@mail.com",
    "url_company":"https://findsol.it",
    "img":"logo company",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{trashBranch}</code></td>
                                        <td>Deleting a branch</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"trashBranch",
"param":{
    "branchId":"177",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="vacancy" role="tabpanel" aria-labelledby="vacancy-tab">
                            <table class="table mt-10">
                                <thead>
                                    <tr>
                                        <th>Function name</th>
                                        <th>Description</th>
                                        <th>Request param</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>{getCategoryVacancy}</code></td>
                                        <td>List of categories for vacancies</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"getCategoryVacancy",
"param":{
    "language":"it",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{newVacancy}</code></td>
                                        <td>Adding a new vacancy</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"newVacancy",
"param":{
    "id_category":"3",
    "id_filial":"178", //if exist
    "title":"Test vacancy",
    "seo":"new_test_vacancy3",
    "tags":"test, vacancy",
    "short_desc":"Test vacancy",
    "full_desc":"This is new test vacancy",
    "country_id":88,
    "region_id":1,
    "province_id":5469372,
    "location":"Treviso",
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{getVacancyList}</code></td>
                                        <td>Get a list of all vacancies</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"getVacancyList",
"param":{
    "secret_key":"your_secret_key"
    }
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{updateVacancy}</code></td>
                                        <td>Update vacancy</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"updateVacancy",
"param":{
    "id": "534",
    "id_user": "296",
    "id_category": "3",
    "id_filial": "178",
    "title": "New vacancy",
    "tags": "new, test, vacancy",
    "seo": "new_vacancy",
    "short_desc": "Test vacancy",
    "full_desc": "This is new test vacancy for testing",
    "country_id":88,
    "region_id":1,
    "province_id":5469372,
    "location":"Treviso",
    "secret_key":"your_secret_key"
    }
}
}</pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>{trashVacancy}</code></td>
                                        <td>Delete vacancy</td>
                                        <td>
<pre class="prettyprint lang-js">
{
"name":"trashVacancy",
"param":{
    "vacancyId":"529",
    "secret_key":"your_secret_key"
    }
}/pre>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->