<?php
class Htmltopdf_model extends CI_Model
{
	function fetch()
	{
		$this->db->order_by('u_id', 'DESC');
		return $this->db->get('register');
	}
	function fetch_single_details($customer_id)
	{
		$this->db->where('u_id', $customer_id);
		$data = $this->db->get('register');
		$output = '<table width="100%" cellspacing="5" cellpadding="5">';
		foreach($data->result() as $row)
		{
			$output .= '
			<tr>
				<td width="75%">
					<p><b>Name : </b>'.$row->name.'</p>
					<p><b>Email : </b>'.$row->email.'</p>
					<p><b>Security Question : </b>'.$row->r_question.'</p>
					<p><b>Security Answer : </b>'.$row->r_answer.'</p>
					<p><b>Verify Statu : </b> '.$row->is_email_verified.' </p>
				</td>
			</tr>
			';
		}
		$output .= '
		<tr>
			<td colspan="2" align="center"><a href="'.base_url().'Pages/get_profile" class="btn btn-primary">Back</a></td>
		</tr>
		';
		$output .= '</table>';
		return $output;
	}
}

?>