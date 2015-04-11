<?php

App::uses('AppController', 'Controller');

/**
 * Reports Controller
 *
 * @property Report $Report
 * @property PaginatorComponent $Paginator
 */
class ReportsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    // the first value
    const FIRST_VALUE = 0;
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->loadModel('Wallet');
        $this->loadModel('Category');
        $this->loadModel('Transaction');
        $this->loadModel('User');
        $wallet = $this->User->Wallet->getAllWallet($this->Auth->user('id'));
        $date = date("Y-m-d", strtotime("first day of this month"));
        $data = $this->Report->query("select * from users left join"
                . " wallets on users.id = wallets.user_id left join categories on wallets.id = categories.wallet_id "
                . " left join transactions on categories.id = transactions.category_id "
                . " where (wallets.id = " . $wallet[0]['users']['current_wallet'] . ""
                . " and transactions.date_of_execution between '" . $date . "' and date_add('" . $date . "', interval 30 day))");
        $expense_arr = '';
        $income_arr = '';
        $i = 0;
        $j = 0;
  
    if(count($data) > 1) {
        $wallet_value = $data[self::FIRST_VALUE]['wallets']['balance'];
        $wallet_id = $data[self::FIRST_VALUE]['wallets']['id'];
        foreach ($data as $category) {
            if ($category['categories']['typename_id'] == 1) {
                $expense_arr[$i] = $category['transactions'];
                $i++;
            } else {
                $income_arr[$j] = $category['transactions'];
                $j++;
            }
        }
        $openning_balance = '';
        $ending_balance = '';
        $expense = '';
        $income = '';
        
        if(count($expense_arr) == 0) {
            $expense = 0;
        } elseif(count($expense_arr) == 1) {
            $expense += $expense_arr[self::FIRST_VALUE]['transaction_value'];
        } else {
            foreach ($expense_arr as $expen) {
                if($expen['parent_transaction'] == null || $expen['parent_transaction'] == '') {
                    $expense += $expen['transaction_value'];
                } else {
                    $expense -= $expen['transaction_value'];
                }
            }
        }
        if(count($income_arr) == 0) {
            $income = 0;
        } elseif(count($income_arr) == 1) {
            $income += $income_arr[self::FIRST_VALUE]['transaction_value'];
        } else {
            foreach ($income_arr as $inco) {
                if($inco['parent_transaction'] == null || $inco['parent_transaction'] == '') {
                    $income += $inco['transaction_value'];
                } else {
                    $income -= $inco['transaction_value'];
                }
            }
        }
        $wallet_value = $wallet_value + $income - $expense;
        $month = date('m');
        $datetime_open = date("Y-m-d", strtotime("last day of this month"));
        $datetime_end = date("Y-m-d", strtotime("first day of this month"));
        foreach ($data as $da) {
            $d = $da['transactions']['date_of_execution'];
            if(strtotime($datetime_open)>  strtotime($d)) {
                $openning_balance = $da['transactions']['id'];
                $datetime_open = $da['transactions']['date_of_execution'];
            }
            if(strtotime($datetime_end)< strtotime($d)) {
                $ending_balance = $da['transactions']['id'];
                $datetime_end = $da['transactions']['date_of_execution'];
            }
        }
        $report = array(
            'wallet' => $wallet_id,
            'month_report' => $month,
            'openning_balance' => $openning_balance,
            'ending_balance' => $ending_balance,
            'net_income' => $wallet_value,
            'expense' => $expense,
            'income' => $income
        );
        if($this->Report->save($report)) {
            $this->Session->setFlash('created monthly report');
            $this->redirect('/transactions/');
        }
    }
        $this->Report->recursive = 0;
        $this->set('reports', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Report->exists($id)) {
            throw new NotFoundException(__('Invalid report'));
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Report->exists($id)) {
            throw new NotFoundException(__('Invalid report'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Report->save($this->request->data)) {
                $this->Session->setFlash(__('The report has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The report could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Report.' . $this->Report->primaryKey => $id));
            $this->request->data = $this->Report->find('first', $options);
        }
        $wallets = $this->Report->Wallet->find('list');
        $this->set(compact('wallets'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Report->id = $id;
        if (!$this->Report->exists()) {
            throw new NotFoundException(__('Invalid report'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Report->delete()) {
            $this->Session->setFlash(__('The report has been deleted.'));
        } else {
            $this->Session->setFlash(__('The report could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
