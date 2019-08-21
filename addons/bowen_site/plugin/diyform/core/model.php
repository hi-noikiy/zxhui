<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url www.we7pc.com
 * <!-- phpDesigner :: Timestamp [2018/8/21 23:52:52] -->
 */
defined('IN_IA') or exit('Access Denied');

class DiyformModel extends PluginModel
{
	public $_data_type_config = array(
        'text' => '单行文本'
        ,'password' => '密码框'
        ,'textarea' => '多行文本'
        ,'select' => '下拉框'
        ,'checkbox' => '多选框'
        ,'radio' => '单选框'
        ,'image' => '图片'
        ,'identity' => '身份证号码'
        ,'date' => '日期'
        ,'date_range' => '日期范围'
        ,'city' => '城市'
        ,'confirm' => '确认文本'
        ,'time' => '时间'
        ,'time_range' => '时间范围'
        ,'word_aux' => '提示文本'
    );
    
	public $_default_data_config = array(
        ''
        ,'自定义'
        //,'姓名'
        //,'电话'
        //,'微信号'
    );
    
	public $_default_date_config = array(
        ''
        ,'填写当天'
        ,'特定日期'
    );
    
    public $_default_searchType_config = array(
        'text'
        ,'select'
        ,'identity'
        ,'date'
        ,'time'
        ,'confirm'
    );

	public function globalData()
	{
		global $_W;
		return array(
            'data_type_config' => $this->_data_type_config
            ,'default_data_config' => $this->_default_data_config
            ,'default_date_config' => $this->_default_date_config
            ,'default_searchType_config' => $this->_default_searchType_config
        );
	}
    
    public function getInsertDataByAdmin()
	{
		global $_W, $_GPC;
		$tp_type = $_GPC['tp_type'];
		$tp_name = $_GPC['tp_name'];
		$placeholder = $_GPC['placeholder'];
		$tp_is_default = $_GPC['tp_is_default'];
		$tp_default = $_GPC['tp_default'];
		$tp_must = $_GPC['tp_must'];
		$tp_text = $_GPC['tp_text'];
		$tp_max = $_GPC['tp_max'];
		$tp_name2 = $_GPC['tp_name2'];
		$tp_area = $_GPC['tp_area'];
		$default_time_type = $_GPC['default_time_type'];
		$default_time = $_GPC['default_time'];
		$default_btime_type = $_GPC['default_btime_type'];
		$default_btime = $_GPC['default_btime'];
		$default_etime_type = $_GPC['default_etime_type'];
		$default_etime = $_GPC['default_etime'];
		$m_pinyin = m('pinyin');

		if (!empty($tp_name)) {
			$data = array();
			$j = 0;

			foreach ($tp_name as $key => $val) {
				$i = $m_pinyin->getPinyin(trim($val), 'diy');

				if (array_key_exists($i, $data)) {
					$i .= $j;
					++$j;
				}

				$temp_tp_type = trim($tp_type[$key]);
				$data[$i]['data_type'] = trim($temp_tp_type);
				$data[$i]['tp_name'] = trim($val);
				$data[$i]['tp_must'] = intval(trim($tp_must[$key]));
				if ($temp_tp_type == 'text' || $temp_tp_type == 'textarea' || $temp_tp_type == 'password') {
					if ($temp_tp_type == 'text') {
						$data[$i]['tp_is_default'] = trim($tp_is_default[$key]);

						if ($data[$i]['tp_is_default']) {
							$data[$i]['tp_default'] = trim($tp_default[$key]);

							switch ($data[$i]['tp_is_default']) {
							case 'diy':
								$data[$i]['tp_default'] = trim($tp_default[$key]);
								break;
							}
						}
					}

					$data[$i]['placeholder'] = trim($placeholder[$key]);
				} else {
					if ($temp_tp_type == 'select' || $temp_tp_type == 'checkbox') {
						$text_array = explode("\n", trim($tp_text[$key]));

						foreach ($text_array as $k => $v) {
							$text_array[$k] = trim($v);
						}

						$data[$i]['tp_text'] = $text_array;
					} else if ($temp_tp_type == 'radio') {
						$text_array = explode("\n", trim($tp_text[$key]));

						foreach ($text_array as $k => $v) {
							$text_array[$k] = trim($v);
						}

						$data[$i]['tp_text'] = $text_array;
					} else if ($temp_tp_type == 'image') {
						$data[$i]['tp_max'] = intval(trim($tp_max[$key]));
					} else if ($temp_tp_type == 'date') {
						$data[$i]['default_time_type'] = intval($default_time_type[$key]);

						if ($data[$i]['default_time_type'] == 2) {
							$data[$i]['default_time'] = trim($default_time[$key]);
						}
					} else if ($temp_tp_type == 'date_range') {
						$data[$i]['default_btime_type'] = intval($default_btime_type[$key]);
						$data[$i]['default_etime_type'] = intval($default_etime_type[$key]);

						if ($data[$i]['default_btime_type'] == 2) {
							$data[$i]['default_btime'] = trim($default_btime[$key]);
						}

						if ($data[$i]['default_etime_type'] == 2) {
							$data[$i]['default_etime'] = trim($default_etime[$key]);
						}
					} else if ($temp_tp_type == 'city') {
						$data[$i]['tp_area'] = intval($tp_area[$key]);
					} else if ($temp_tp_type == 'confirm') {
						$data[$i]['tp_name2'] = trim($tp_name2[$key]);
					} else {
						if ($temp_tp_type == 'word_aux') {
							$data[$i]['tp_text'] = trim($tp_text[$key]);
						}
					}
				}
			}
		}

		return $data;
	}
    
    public function getPostDatas($fields, $field_data_name = 'field_data')
	{
		global $_W,$_GPC;
		$diyformfields = array();
		$key = 0;

		foreach ($fields as $field => $value) {
			$tp_value = '';
			if ($value['data_type'] == 'text' || $value['data_type'] == 'password' || $value['data_type'] == 'textarea' || $value['data_type'] == 'select' || $value['data_type'] == 'identity' || $value['data_type'] == 'date' || $value['data_type'] == 'time' || $value['data_type'] == 'confirm') {
				$tp_value = trim($_GPC[$field_data_name . $key]);
				if (empty($tp_value) && $value['tp_must']) {
                    $this->result(-1, '请填写' . $value['tp_name']);
				}
			}
			else if ($value['data_type'] == 'checkbox') {
				if (is_array($_GPC[$field_data_name . $key])) {
				    $tp_value = implode(',', $_GPC[$field_data_name . $key]);
				}

				if (empty($tp_value) && $value['tp_must']) {
					$this->result(-1, '请选择' . $value['tp_name']);
				}
			}
			else if ($value['data_type'] == 'image') {
				$tp_value = array();

				if (is_array($_GPC[$field_data_name . $key])) {
					$tp_value = $_GPC[$field_data_name . $key];
				}

				if (empty($tp_value) && $value['tp_must']) {
					$this->result(-1, '请选择' . $value['tp_name']);
				}
			}
			else {
				if ($value['data_type'] == 'date_range' || $value['data_type'] == 'time_range') {
					$tp_value = trim($_GPC[$field_data_name . $key]);
                    $tp_value2 = explode(" - ", $tp_value);

					if (count($tp_value2) != 2 && $value['tp_must']) {
						$this->result(-1, '请选择' . $value['tp_name']);
					}
				}
				else if ($value['data_type'] == 'city') {
					$tp_value = array();
					if (!empty($_GPC[$field_data_name . $key]['province'])) {
						$tp_value['province'] = $_GPC[$field_data_name . $key]['province'];
					}

                    if (!empty($_GPC[$field_data_name . $key]['city'])) {
						$tp_value['city'] = $_GPC[$field_data_name . $key]['city'];
					}

                    if (!empty($_GPC[$field_data_name . $key]['area'])) {
						$tp_value['area'] = $_GPC[$field_data_name . $key]['area'];
					}

					if ((!isset($tp_value['province']) || !isset($tp_value['city'])) && $value['tp_must']) {
						$this->result(-1, '请选择' . $value['tp_name']);
					}
				}
				else {
					if ($value['data_type'] == 'radio') {
						$tp_value = trim($_GPC[$field_data_name . $key]);

						if (empty($tp_value) && $value['tp_must']) {
							$this->result(-1, '请选择' . $value['tp_name']);
						}
					}
				}
			}

			$diyformfields[$field] = $tp_value;
			++$key;
		}

		return $diyformfields;
	}
    
    private function result($errno = '0', $message = '', $data = array(), $params = array(), $type = 'exit')
    {
        return result($errno, $message, $data, $params, $type);
    }
}
