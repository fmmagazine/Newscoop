<div id="genericform">
{{ user_form template="subscription.tpl" button_html_code="class=\"submitbutton\"" }}
<table class="userform">
	<tr>
		<th colspan="2">Please fill in the following form in order to create
		the subscription account.</th>
	</tr>
	<tr>
		<td><span class="formtext">Subscription type:</span></td>
		<td><select name="SubsType">
			<option value="trial">Trial</option>
			<option value="paid">Paid</option>
		    </select>
        </td>
	</tr>
	<tr>
		<td><span class="formtext">Full name:</span></td>
		<td>{{ camp_edit object="user" attribute="name" html_code="class=\"input_long\"" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Login name:</span></td>
		<td>{{ camp_edit object="user" attribute="uname" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Password:</span></td>
		<td>{{ camp_edit object="user" attribute="password" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Password confirmation:</span></td>
		<td>{{ camp_edit object="user" attribute="passwordagain" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Email:</span></td>
		<td>{{ camp_edit object="user" attribute="email" html_code="class=\"input_long\"" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Country:</span></td>
		<td>{{ camp_select object="user" attribute="country" html_code="class=\"select_long\"" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">City:</span></td>
		<td>{{ camp_edit object="user" attribute="city" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Street address:</span></td>
		<td>{{ camp_edit object="user" attribute="str_address" html_code="class=\"input_long\"" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">State:</span></td>
		<td>{{ camp_edit object="user" attribute="state" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Phone:</span></td>
		<td>{{ camp_edit object="user" attribute="phone" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Fax:</span></td>
		<td>{{ camp_edit object="user" attribute="fax" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Contact:</span></td>
		<td>{{ camp_edit object="user" attribute="contact" html_code="class=\"input_long\"" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Second phone:</span></td>
		<td>{{ camp_edit object="user" attribute="second_phone" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Postal code:</span></td>
		<td>{{ camp_edit object="user" attribute="postal_code" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Gender:</span></td>
		<td>
		  <span class="formtext">
		  {{ camp_select object="user" attribute="gender" male_name="male"
		     female_name="female" }}
		  </span>
		</td>
	</tr>
	<tr>
		<td><span class="formtext">Title:</span></td>
		<td>{{ camp_select object="user" attribute="title" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Age:</span></td>
		<td>{{ camp_select object="user" attribute="age" }}</td>
	</tr>
	<tr>
		<td><span class="formtext">Interests:</span></td>
		<td>{{ camp_edit object="user" attribute="interests" }}</td>
	</tr>
</table>
<div align="center">{{ /user_form }}</div>
</div>
