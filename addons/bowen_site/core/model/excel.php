<?php
/**
 * 玖祺企业官网
 *
 * @author Bowen
 * @url https://www.w7pc.com/
 * <!-- phpDesigner :: Timestamp [2018-09-07 17:57:42] -->
 */
defined('IN_IA') or exit('Access Denied');

class Excel_Model
{
	protected function column_str($key)
	{
		$array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ', 'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ', 'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ', 'EK', 'EL', 'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW', 'EX', 'EY', 'EZ');
		return $array[$key];
	}

	protected function column($key, $columnnum = 1)
	{
		return $this->column_str($key) . $columnnum;
	}

	/**
     * 导出Excel
     * @param type $list
     * @param type $params
     */
	public function export($list, $params = array())
	{
		if (PHP_SAPI == 'cli') {
			exit('This example should only be run from a Web Browser');
		}
        
        load()->library('phpexcel/PHPExcel');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('玖祺科技')->setLastModifiedBy('玖祺企业官网')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('report file');
		$sheet = $excel->setActiveSheetIndex(0);
		$rownum = 1;

		foreach ($params['columns'] as $key => $column) {
			$sheet->setCellValue($this->column($key, $rownum), $column['title']);

			if (!empty($column['width'])) {
				$sheet->getColumnDimension($this->column_str($key))->setWidth($column['width']);
			}
		}

		++$rownum;
		$len = count($params['columns']);

		foreach ($list as $row) {
			$i = 0;

			while ($i < $len) {
				$value = isset($row[$params['columns'][$i]['field']]) ? $row[$params['columns'][$i]['field']] : '';
				$sheet->setCellValue($this->column($i, $rownum), $value);
				++$i;
			}

			++$rownum;
		}

		$excel->getActiveSheet()->setTitle($params['title']);
		$filename = urlencode($params['title'] . '-' . date('Y-m-d H:i', time()));
		ob_end_clean();
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$this->SaveViaTempFile($writer);
		exit();
	}

	/**
     * @param $objWriter PHPExcel_Writer_IWriter
     */
	public function SaveViaTempFile($objWriter)
	{
		$filePath = '' . rand(0, getrandmax()) . rand(0, getrandmax()) . '.tmp';
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}

	/**
     * 生成模板文件Excel
     * @param type $list
     * @param type $params
     */
	public function temp($title, $columns = array())
	{
		if (PHP_SAPI == 'cli') {
			exit('This example should only be run from a Web Browser');
		}

		load()->library('phpexcel/PHPExcel');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('玖祺企业官网')->setLastModifiedBy('玖祺企业官网')->setTitle('Office 2007 XLSX Test Document')->setSubject('Office 2007 XLSX Test Document')->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')->setKeywords('office 2007 openxml php')->setCategory('report file');
		$sheet = $excel->setActiveSheetIndex(0);
		$rownum = 1;

		foreach ($columns as $key => $column) {
			$sheet->setCellValue($this->column($key, $rownum), $column['title']);

			if (!empty($column['width'])) {
				$sheet->getColumnDimension($this->column_str($key))->setWidth($column['width']);
			}
		}

		++$rownum;
		$len = count($columns);
		$k = 1;

		while ($k <= 5000) {
			$i = 0;

			while ($i < $len) {
				$sheet->setCellValue($this->column($i, $rownum), '');
				++$i;
			}

			++$rownum;
			++$k;
		}

		$excel->getActiveSheet()->setTitle($title);
		$filename = urlencode($title);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$writer->save('php://output');
		exit();
	}

	public function import($excefile)
	{
		global $_W;
        load()->library('phpexcel/PHPExcel');
        load()->library('phpexcel/PHPExcel/IOFactory');
        load()->library('phpexcel/PHPExcel/Reader/Excel5');
        /**
         * 改为封装的加载机制
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/IOFactory.php';
		require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/Reader/Excel5.php';
        */
		$path = IA_ROOT . '/addons/' . MODULE_NAME . '/data/tmp/';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path, '0777');
		}

		$filename = $_FILES[$excefile]['name'];
		$tmpname = $_FILES[$excefile]['tmp_name'];

		if (empty($tmpname)) {
			//mymessage('请选择要上传的Excel文件!', '', 'error');
            result(-1, '请选择要上传的Excel文件');
		}

		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if ($ext != 'xlsx' && $ext != 'xls') {
			//mymessage('请上传 xls 或 xlsx 格式的Excel文件!', '', 'error');
            result(2, '请上传 xls 或 xlsx 格式的Excel文件');
		}

		$file = time() . $_W['uniacid'] . '.' . $ext;
		$uploadfile = $path . $file;
		$result = move_uploaded_file($tmpname, $uploadfile);

		if (!$result) {
			//mymessage('上传Excel 文件失败, 请重新上传!', '', 'error');
            result(2, '上传Excel 文件失败, 请重新上传');
		}

		$reader = PHPExcel_IOFactory::createReader($ext == 'xls' ? 'Excel5' : 'Excel2007');
		$excel = $reader->load($uploadfile);
		$sheet = $excel->getActiveSheet();
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnCount = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$values = array();
		$row = 1;

		while ($row <= $highestRow) {
			$rowValue = array();
			$col = 0;

			while ($col < $highestColumnCount) {
				$rowValue[] = (string) $sheet->getCellByColumnAndRow($col, $row)->getValue();
				++$col;
			}

			$values[] = $rowValue;
			++$row;
		}
        
		return $values;
	}
}
