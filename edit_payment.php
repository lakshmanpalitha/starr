<?php
include('link_service.php');
    $id = 0;
    $benifiter_id = 0;
    $nic = "";
    $pay_type_id = 0;
    $permit_no = "";
    $amount = 0;
    $bank_code = "";
    $branch_code = "";
    $account_no = "";
    $branch_name = "";
    $bank_name = "";
    $name = "";
    $land_size = 0;
    $permit_no1 = "";
    $permit_no2 = "";
    $permit_no3 = "";
    $paid_as = "";
    $cheque_lot_no = "";
    $pending_payment_id=50;
    $data_permit = null;
    
    if(isset($_GET['id']))
        $id = $_GET['id'];
    if(isset($_GET['benifiter_id']))
        $benifiter_id = $_GET['benifiter_id'];
    if(isset($_GET['nic']))
        $nic = $_GET['nic'];
    if(isset($_GET['pay_type_id']))
        $pay_type_id = $_GET['pay_type_id'];
    if(isset($_GET['permit_no']))
        $permit_no = $_GET['permit_no'];
    if(isset($_GET['amount']))
        $amount = $_GET['amount'];
    if(isset($_GET['bank_code']))
        $bank_code = $_GET['bank_code'];
    if(isset($_GET['branch_code']))
        $branch_code = $_GET['branch_code'];
    if(isset($_GET['account_no']))
        $account_no = $_GET['account_no'];
    if(isset($_GET['paid_as']))
        $paid_as = $_GET['paid_as'];
    if(isset($_GET['cheque_lot_no']))
        $cheque_lot_no = $_GET['cheque_lot_no'];
    
    if($id > 0)    
    {
        $data = callService("/get_payment_by_id/$id");        
    }
    
    if($benifiter_id > 0)    
    {
        $data_benifiter = callService("/get_benifiter_by_id/$benifiter_id");
        $row_benifiter = $data_benifiter[0];
        $name = $row_benifiter->name;
        $nic = $row_benifiter->nic_no;
        $bank_code = $row_benifiter->bank_code;
        $branch_code = $row_benifiter->branch_code;
        $account_no = $row_benifiter->account_no;
        $branch_name = $row_benifiter->branch_name;
        $bank_name = $row_benifiter->bank_name;
        
        $data_permit = callService("/get_permits_by_benifiter/$benifiter_id");
        if($data_permit != null)
        {
            $row_permit = $data_permit[0];
            $land_size = 0;
            if($row_permit->land_size_act_ha != "")
                $land_size = $row_permit->land_size_act_ha;
            else
                $land_size = $row_permit->land_size_init_ha;
        }
    }
                
?>

    <div id="model_content" class="modal-body">
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="txt_fname">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_id" value="<?php echo $id; ?>">
            </div>
          </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="txt_benifiter_id_payement">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_benifiter_id_payement" value="<?php echo $benifiter_id; ?>">
            </div>
          </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="lblBankCode">Bank code:</label>
            <div class="col-sm-10">
              <span id="lblBankCode" ><?php echo $bank_code; ?></span>
            </div>
          </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="lblBranchCode">Bank code:</label>
            <div class="col-sm-10">
              <span id="lblBranchCode" ><?php echo $branch_code; ?></span>
            </div>
          </div>
          
          <div class="row">
              <div class="col-lg-7 col-sm-7">
                  <div class="form-group">
                    <label class="control-label col-lg-3" for="cmb_pay_type_payment">Permit No:</label>
                    <div class="col-lg-9">
                      <select class="selectpicker" data-live-search="true" title="Select Permit" id="cmb_permit" required>
                        <?php
                            foreach ($data_permit as $pmt) {
                        ?>
                            <option data-tokens="<?php echo $pmt->permit_no; ?>" value="{&quot;permit_no&quot;:&quot;<?php echo $pmt->permit_no; ?>&quot;, &quot;benifiter_id&quot;:<?php echo $pmt->benifiter_id; ?>, &quot;crop_id&quot;:<?php echo $pmt->crop_id; ?>, &quot;land_size_init_ha&quot;:<?php echo $pmt->land_size_init_ha; ?>, &quot;land_size_act_ha&quot;:<?php echo ($pmt->land_size_act_ha != "") ? $pmt->land_size_act_ha : 0; ?>}" <?php if ($pmt === reset($data_permit)) { echo 'selected'; }?>> <?php echo $pmt->permit_no; ?></option>
                        <?php
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <label class="control-label col-lg-3" for="cmb_pay_type_payment">Pay type:</label>
                    <div class="col-lg-9">
                        <select class="selectpicker" data-live-search="true" title="Select Payment Type" id="cmb_pay_type_payment" required>
                        <?php
                            $data_pay_types = callService("/get_pay_types_for_benifiter/$benifiter_id?permit_no=" . $data_permit[0]->permit_no . "&crop_id=" . $data_permit[0]->crop_id); //only pending payments are displayed
                            //$data_pay_types = callService("/get_all_pay_types"); //uncoment this if all types are required to display
                            $pending_payment_id = $data_pay_types[0]->id; //top most pending payment is the next payment to go
                            $pending_payment_rate = $data_pay_types[0]->rate_per_ha; 
                            foreach ($data_pay_types as $pt) {
                        ?>
                            <option data-tokens="<?php echo $pt->name; ?>" value="{&quot;id&quot;:<?php echo $pt->id; ?>, &quot;rate_per_ha&quot;:<?php echo $pt->rate_per_ha; ?>}" 
                                            <?php echo ($pending_payment_id == $pt->id) ? "selected" :"disabled";?>><?php echo $pt->name; ?></option>
                        <?php
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-lg-3" for="txt_amount_payment">Amount (Rs):</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" id="txt_amount_payment" placeholder="Enter amount" value="<?php echo ($id > 0) ? "0" : $pending_payment_rate * $land_size; ?>">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-lg-3" for="permit_no">Paid as:</label>
                    <div class="col-lg-9">
                        <label class="radio-inline"><input checked="" type="radio" id="chk_paid_as" name="chk_paid_as" value="cheque">Cheque</label>
                        <label class="radio-inline"><input type="radio" id="chk_paid_as" name="chk_paid_as" value="lot">Lot</label>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-lg-3" for="txt_cheque_lot_no">Cheque/Lot #:</label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" name="txt_cheque_lot_no" id="txt_cheque_lot_no" placeholder="Enter Cheque/Lot No" required>
                    </div>
                  </div>
                  
                  
                </div>
              
              
              <div class="col-lg-5 col-sm-5"> 
                    <div class="form-group"> 
                        <label class="col-lg-4 text-right" for="lblName">Name:</label>
                        <div class="col-lg-8">
                          <span id="lblName" ><?php echo $name; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 text-right" for="lblNIC">NIC:</label>
                        <div class="col-lg-8">
                          <span id="lblNIC" ><?php echo $nic; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 text-right" for="lblLandSize">Land Size:</label>
                        <div class="col-lg-8">
                          <span id="lblLandSize" ><?php echo $land_size; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 text-right" for="lblBank">Bank:</label>
                        <div class="col-lg-8">
                          <span id="lblBank" ><?php echo $bank_name; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 text-right" for="lblBranch">Branch:</label>
                        <div class="col-lg-8">
                          <span id="lblBranch" ><?php echo $branch_name; ?></span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-4 text-right" for="lblAccountNo">Acc No:</label>
                        <div class="col-lg-8">
                          <span id="lblAccountNo" ><?php echo $account_no; ?></span>
                        </div>
                    </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#collapse1">Previous Payments</a>
                            </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse">
                            <table class="table table-hover" id="prev_payment_tbl">
                                <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th></th>
                                  </tr>
                                </thead>
                                <tbody style="max-height: 150px;">
                                    <?php
                                        $data_pay = callService("/get_payments_by_benifiter/$benifiter_id?permit_no=" . $data_permit[0]->permit_no);
                                        foreach ($data_pay as $pay) {
                                    ?>
                                        <tr>
                                            <td><?php echo $pay->payment_type; ?></td>
                                            <td><?php echo $pay->amount; ?></td>
                                            <td><?php echo $pay->pay_date; ?></td>
                                            <td><?php echo $pay->comment; ?></td>
                                            <?php
                                                if ($pay === end($data_pay)) { //show revert button
                                                ?>
                                                    <td><button type="button" id="<?php echo "rev_" . $pay->id; ?>" class="btn btn-primary btn-xs revert"  data-toggle="collapse" data-target="#revert_comment">Revert</button></td>
                                                <?php
                                                }
                                            ?>
                                        </tr>
                                        
                                        <?php
                                            if ($pay === end($data_pay)) { //show revert comment
                                            ?>
                                                <tr id="revert_comment" class="collapse"><td colspan = "3"><textarea id="txtRevComment"></textarea></td></div> <td></td> <td></td> <td><button id="<?php echo "revert_" . $pay->id; ?>" type="button" class="btn btn-default save_revert">save</button></td></tr>
                                            <?php
                                            }
                                        ?>
                                            
                                    <?php
                                        }
                                    ?>
                                </tbody> 
                              </table>
                          </div>
                        </div>
                  </div>
              </div>
          </div>
          <!--
          <div class="modal-footer">
            <button id="btnPaySave" type="submit" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          -->  
    </div>