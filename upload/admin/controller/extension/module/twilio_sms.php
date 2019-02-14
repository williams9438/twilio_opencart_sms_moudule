<?php
class ControllerExtensionModuleTwilioSms extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/twilio_sms');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_twilio_sms', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/twilio_sms', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/twilio_sms', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_twilio_sms_sms_status'])) {
			$data['module_twilio_sms_status'] = $this->request->post['module_twilio_sms_status'];
		} else {
			$data['module_twilio_sms_status'] = $this->config->get('module_twilio_sms_status');
		}

		if (isset($this->request->post['module_twilio_sms_account_sid'])) {
			$data['module_twilio_sms_account_sid'] = $this->request->post['module_twilio_sms_account_sid'];
		} else {
			$data['module_twilio_sms_account_sid'] = $this->config->get('module_twilio_sms_account_sid');
		}

		if (isset($this->request->post['module_twilio_sms_account_auth_token'])) {
			$data['module_twilio_sms_account_auth_token'] = $this->request->post['module_twilio_sms_account_auth_token'];
		} else {
			$data['module_twilio_sms_account_auth_token'] = $this->config->get('module_twilio_sms_account_auth_token');
		}

		if (isset($this->request->post['module_twilio_sms_account_phone_number'])) {
			$data['module_twilio_sms_account_phone_number'] = $this->request->post['module_twilio_sms_account_phone_number'];
		} else {
			$data['module_twilio_sms_account_phone_number'] = $this->config->get('module_twilio_sms_account_phone_number');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/twilio_sms', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/twilio_sms')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}