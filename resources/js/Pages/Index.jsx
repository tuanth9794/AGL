import React, { useState } from 'react';
import { Button, Form, Input, Table, Divider, Tag} from 'antd';
import axios from 'axios';

const columns = [
  {
    title: 'Keyword',
    dataIndex: 'keyword',
    key: 'keyword',
    render: text => <a href="javascript:;">{text}</a>,
  },
  {
    title: 'Google rank',
    dataIndex: 'googleRank',
    key: 'googleRank',
  },
  {
    title: 'Google search',
    dataIndex: 'googleSearch',
    key: 'googleSearch',
  },
  {
    title: 'Yahoo rank',
    dataIndex: 'yahooRank',
    key: 'yahooRank',
  },
  {
    title: 'Yahoo search',
    dataIndex: 'yahooSearch',
    key: 'yahooSearch',
  },
  
];

const data = [{'id':0}];

componentDidMount() {
    axios.get('http://localhost/public/api/keyword/')
      .then(res => {
        this.setState({
          keywords: res.data
        });
      })
      .catch((error) => {
        console.log(error);
      })
  }


const Index = () => {

    return (
    <>
        <Form
    name="wrap"
    labelCol={{ flex: '110px' }}
    labelAlign="left"
    labelWrap
    wrapperCol={{ flex: 1 }}
    colon={false}
    style={{ maxWidth: 600 }}
  >
    <Form.Item label="URL" name="website" rules={[{ required: true }]}>
      <Input />
    </Form.Item>

    <Form.Item label="Keywords" name="keyword" rules={[{ required: true }]}>
      <Input.TextArea/>
    </Form.Item>
       
    <Form.Item label=" ">
      <Button type="primary" htmlType="submit">
        Search
      </Button>
    </Form.Item>
  </Form>
<Table columns={columns} dataSource={data} scroll={{x: 768}} />
  </>
    )
}

export default Index
